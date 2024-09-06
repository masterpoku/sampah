#include <Wire.h>
#include <FS.h>
#include <ESP8266WiFi.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <WiFiManager.h>
#include <ArduinoJson.h>
#include <LiquidCrystal_I2C.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include <Arduino_JSON.h>
#include <ESP8266HTTPClient.h> // Header HTTPClient untuk ESP8266

// Pin Definitions
#define PH_PIN A0
#define BUZZER_PIN 15
#define lampuHijau D6
#define lampuMerah D7
#define lampuKuning D8 // Pin baru untuk lampu kuning

// LCD Setup
LiquidCrystal_I2C lcd(0x27, 20, 4); // 20x4 LCD

// Sensor Setup
OneWire oneWire(PH_PIN);
DallasTemperature sensors(&oneWire);

// Global Variables
char email[40] = " ";
char password[30] = " ";
char host_ip[15] = " ";
char id_device[10] = " ";
String response;
bool shouldSaveConfig = false;

float Po = 0;
float PH_step;
int nilai_analog_PH;
double TeganganPh;
const float PH4 = 3.226;
const float PH7 = 2.691;

const long interval = 10; // Interval in milliseconds
unsigned long previousMillis = 0;

WiFiClient wifiClient;

void saveConfigCallback() {
  Serial.println("Should save config");
  shouldSaveConfig = true;
}

void setupWiFi() {
  WiFiManager wifiManager;
  WiFiManagerParameter custom_email("email", "email", email, 40);
  WiFiManagerParameter custom_password("password", "password", password, 30);
  WiFiManagerParameter custom_host_ip("host_ip", "host_ip", host_ip, 15);
  WiFiManagerParameter custom_id_device("id_device", "id_device", id_device, 10);

  wifiManager.setSaveConfigCallback(saveConfigCallback);
  wifiManager.addParameter(&custom_email);
  wifiManager.addParameter(&custom_password);
  wifiManager.addParameter(&custom_host_ip);
  wifiManager.addParameter(&custom_id_device);

  if (!wifiManager.autoConnect("SmartPh", "password")) {
    Serial.println("Failed to connect and hit timeout");
    delay(3000);
    ESP.reset();
    delay(5000);
  }

  Serial.println("Connected...yeey :)");

  strcpy(email, custom_email.getValue());
  strcpy(password, custom_password.getValue());
  strcpy(host_ip, custom_host_ip.getValue());
  strcpy(id_device, custom_id_device.getValue());

  Serial.println("The values in the file are: ");
  Serial.println("\temail : " + String(email));
  Serial.println("\tpassword : " + String(password));
  Serial.println("\thost_ip : " + String(host_ip));
  Serial.println("\tid_device : " + String(id_device));

  if (shouldSaveConfig) {
    Serial.println("Saving config");
    DynamicJsonDocument json(1024);
    json["email"] = email;
    json["password"] = password;
    json["host_ip"] = host_ip;
    json["id_device"] = id_device;

    File configFile = SPIFFS.open("/config1.json", "w");
    if (!configFile) {
      Serial.println("Failed to open config file for writing");
    }

    serializeJson(json, Serial);
    serializeJson(json, configFile);
    configFile.close();
  }

  Serial.println("Local IP: " + WiFi.localIP().toString());
}

void loadConfig() {
  Serial.println("Mounting FS...");

  if (SPIFFS.begin()) {
    Serial.println("Mounted file system");
    if (SPIFFS.exists("/config1.json")) {
      Serial.println("Reading config file");
      File configFile = SPIFFS.open("/config1.json", "r");
      if (configFile) {
        Serial.println("Opened config file");
        size_t size = configFile.size();
        std::unique_ptr<char[]> buf(new char[size]);
        configFile.readBytes(buf.get(), size);

        DynamicJsonDocument json(1024);
        auto deserializeError = deserializeJson(json, buf.get());
        serializeJson(json, Serial);
        if (!deserializeError) {
          Serial.println("\nParsed JSON");
          strcpy(email, json["email"]);
          strcpy(password, json["password"]);
          strcpy(host_ip, json["host_ip"]);
          strcpy(id_device, json["id_device"]);
        } else {
          Serial.println("Failed to load JSON config");
        }
        configFile.close();
      }
    }
  } else {
    Serial.println("Failed to mount FS");
  }
}

void postHttp() {
  String url = "http://" + String(host_ip) + ":80/nodemcu/public/api/login";
  HTTPClient http;

  StaticJsonDocument<200> var;
  String jsonParams;
  var["email"] = email;
  var["password"] = password;

  serializeJson(var, jsonParams);
  Serial.println(jsonParams);

  http.begin(wifiClient, url);
  http.addHeader("Content-Type", "application/json");

  http.POST(jsonParams);
  response = http.getString();
  Serial.println(response);
}

void sendData() {
  String responses;
  nilai_analog_PH = analogRead(PH_PIN);
  TeganganPh = 3.3 / 1024.0 * nilai_analog_PH;

  PH_step = (PH4 - PH7) / 3;
  Po = 7.00 + ((PH7 - TeganganPh) / PH_step);
  sensors.requestTemperatures();
  String TokenSend = "Bearer " + response;
  HTTPClient sendData;
  sendData.begin(wifiClient, "http://" + String(host_ip) + ":80/nodemcu/public/api/send");
  sendData.addHeader("Authorization", TokenSend);
  sendData.addHeader("Content-Type", "application/json");

  StaticJsonDocument<200> tuf;
  String jsonPara;
  tuf["id_device"] = id_device;
  tuf["tegangan"] = TeganganPh;
  tuf["ph"] = Po;
  tuf["temp"] = sensors.getTempCByIndex(0);

  serializeJson(tuf, jsonPara);
  sendData.POST(jsonPara);
  responses = sendData.getString();
  Serial.println(responses);
  sendData.end();
  delay(200);
}

void kontrol() {
  String Token = "Bearer " + response;
  Serial.println(Token);
  HTTPClient control;
  control.begin(wifiClient, "http://" + String(host_ip) + ":80/nodemcu/public/api/control/" + String(id_device));
  control.addHeader("Authorization", Token);
  control.addHeader("Content-Type", "application/json");
  int httpCode = control.GET();

  unsigned long currentMillis = millis();
  if (currentMillis - previousMillis >= interval) {
    if (WiFi.status() == WL_CONNECTED) {
      if (httpCode > 0) {
        String payload = control.getString();
        JSONVar myObject = JSON.parse(payload);
        Serial.print("JSON object = ");
        Serial.println(myObject);

        JSONVar keys = myObject.keys();

        for (int i = 0; i < keys.length(); i++) {
          JSONVar value = myObject[keys[i]];
          Serial.print("GPIO: ");
          Serial.print(keys[i]);
          Serial.print(" - SET to: ");
          Serial.println(value);
          pinMode(atoi(keys[i]), OUTPUT);
          digitalWrite(atoi(keys[i]), atoi(value));
        }
        previousMillis = currentMillis;
      }
      control.end();
    }
  }
}

void handleAutomaticMode() {
  Serial.println("Mode Automatic");
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Status Mode: Automatic");

  Serial.println(Po);
  Serial.println(TeganganPh);
  float temperature = sensors.getTempCByIndex(0);

  lcd.setCursor(0, 1);
  lcd.print("PH: " + String(Po));
  lcd.setCursor(0, 2);
  lcd.print("Tegangan: " + String(TeganganPh));
  lcd.setCursor(0, 3);
  lcd.print("Temp: " + String(temperature) + "C");

  if (Po < 6) {
    Serial.println("PH Acid");
    digitalWrite(BUZZER_PIN, HIGH);
    digitalWrite(lampuMerah, LOW);
    digitalWrite(lampuHijau, HIGH);
    digitalWrite(lampuKuning, HIGH); // Lampu kuning hidup jika pH Acid
    lcd.setCursor(10, 3);
    lcd.print("ACID");
  } else if (Po == 6) {
    Serial.println("PH Normal");
    digitalWrite(BUZZER_PIN, LOW);
    digitalWrite(lampuMerah, LOW);
    digitalWrite(lampuHijau, HIGH);
    digitalWrite(lampuKuning, LOW); // Matikan lampu kuning jika pH Normal
    lcd.setCursor(10, 3);
    lcd.print("NORMAL");
  } else if (Po > 7) {
    Serial.println("PH Alkaline");
    digitalWrite(BUZZER_PIN, HIGH);
    digitalWrite(lampuMerah, HIGH);
    digitalWrite(lampuHijau, LOW);
    digitalWrite(lampuKuning, HIGH); // Lampu kuning hidup jika pH Alkaline
    lcd.setCursor(10, 3);
    lcd.print("ALKALINE");
  }
}

void handleManualMode() {
  Serial.println("Mode Manual");
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Status Mode: Manual");

  kontrol();

  float temperature = sensors.getTempCByIndex(0);

  lcd.setCursor(0, 1);
  lcd.print("PH: " + String(Po));
  lcd.setCursor(0, 2);
  lcd.print("Tegangan: " + String(TeganganPh));
  lcd.setCursor(0, 3);
  lcd.print("Temp: " + String(temperature) + "C");

  if (Po < 6) {
    Serial.println("PH Acid");
    digitalWrite(BUZZER_PIN, HIGH);
    digitalWrite(lampuMerah, LOW);
    digitalWrite(lampuHijau, HIGH);
    digitalWrite(lampuKuning, HIGH); // Lampu kuning hidup jika pH Acid
    lcd.setCursor(10, 3);
    lcd.print("ACID");
  } else if (Po == 6) {
    Serial.println("PH Normal");
    digitalWrite(BUZZER_PIN, LOW);
    digitalWrite(lampuMerah, LOW);
    digitalWrite(lampuHijau, HIGH);
    digitalWrite(lampuKuning, LOW); // Matikan lampu kuning jika pH Normal
    lcd.setCursor(10, 3);
    lcd.print("NORMAL");
  } else if (Po > 7) {
    Serial.println("PH Alkaline");
    digitalWrite(BUZZER_PIN, HIGH);
    digitalWrite(lampuMerah, HIGH);
    digitalWrite(lampuHijau, LOW);
    digitalWrite(lampuKuning, HIGH); // Lampu kuning hidup jika pH Alkaline
    lcd.setCursor(10, 3);
    lcd.print("ALKALINE");
  }
}

void setup() {
  pinMode(PH_PIN, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(lampuHijau, OUTPUT);
  pinMode(lampuMerah, OUTPUT);
  pinMode(lampuKuning, OUTPUT); // Inisialisasi pin untuk lampu kuning

  Serial.begin(115200);
  lcd.init();
  lcd.backlight();
  Serial.println();

  // Clean FS, for testing
  // SPIFFS.format();

  loadConfig();
  setupWiFi();
  postHttp();
}

void loop() {
  sensors.requestTemperatures();

  String TokenMode = "Bearer " + response;
  String LinkRelay;
  HTTPClient httpRelay;
  LinkRelay = "http://" + String(host_ip) + ":80/nodemcu/public/api/get-kontrol";
  httpRelay.begin(wifiClient, LinkRelay);
  httpRelay.addHeader("Authorization", TokenMode);
  httpRelay.addHeader("Content-Type", "application/json");
  httpRelay.GET();
  String Respon = httpRelay.getString();
  httpRelay.end();

  if (Respon.toInt() == 0) {
    handleAutomaticMode();
  } else {
    handleManualMode();
  }

  sendData();
  delay(1000); // Adjust delay as needed for your application
}
