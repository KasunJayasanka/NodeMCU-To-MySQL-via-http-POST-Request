#include <SoftwareSerial.h>
#ifdef ESP32
#include <WiFi.h>
#include <HTTPClient.h>
#else
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#endif
#include <Wire.h>

// Replace with your network credentials
const char* ssid     = "Iman_WIFI";
const char* password = "12345678";

const char* serverName = "https://nodemcu-test-post-1a425dfad810.herokuapp.com/dbwrite.php?";
String apiKeyValue = "tPmAT5Ab3j7F9";

void setup() {
  Serial.begin(9600);
 
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

}

void loop() {
  //-------------------------------------------Check WiFi connection status-----------------------------------------------
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    WiFiClient client;

    //---------------------------------------- Domain name with URL path or IP address with path---------------------------------------
    http.begin(client,serverName);

    //-------------------------------------------------------Specify content-type header-----------------------------------------------
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    boolean s=true;
    if (s) {
      String sensorValue = String(random(100)); //--------------------------read data from arduino----------------------------
      Serial.println(sensorValue); 
      
      //---------------------------------HTTP Request--------------------------------------------------------------
        String httpRequestData = "apiKey=tPmAT5Ab3j7F9&sensorValue=" + sensorValue;
        Serial.print("httpRequestData: ");
        Serial.println(httpRequestData);
        int httpResponseCode = http.POST(httpRequestData);
        if (httpResponseCode > 0) {
          Serial.print("HTTP Response code: ");
          Serial.println(httpResponseCode);
        }
        else {
          Serial.print("Error code: ");
          Serial.println(httpResponseCode);
        }
        http.end();
    }

  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(2000);
}
