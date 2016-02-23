// This #include statement was automatically added by the Particle IDE.
#include "application.h"
#include "HttpClient.h"

//#include "rest_client.h"

#define publish_delay 10000 //15 seconds
unsigned int lastPublish = 0;

int ledOne        = D0;
int ledTwo        = D1;
int switchOne     = D2;
int switchTwo     = D3;
int switchThree   = D4;
bool ledOneStatus = false;
bool ledTwoStatus = false;

/**
* Declaring the variables.
*/
unsigned int nextTime = 0;    // Next time to contact the server
HttpClient http;

// Headers currently need to be set at init, useful for API keys etc.
http_header_t headers[] = {
    { "Content-Type", "application/json" },
    { "Authorization", "Basic sorryicantputthishere" },
    //  { "Accept" , "application/json" },
    { "Accept" , "*/*" },
    { NULL, NULL } // NOTE: Always terminate headers will NULL
};

http_request_t ledOneRequest;
http_request_t ledTwoRequest;
http_request_t switchOneRequest;
http_request_t switchTwoRequest;
http_request_t switchThreeRequest;

http_response_t response;

void setup() {
    //initialize serial communication
    Serial.begin(9600);

    pinMode(ledOne, OUTPUT);
    pinMode(ledTwo, OUTPUT);
    pinMode(switchOne, INPUT);
    pinMode(switchTwo, INPUT);
    pinMode(switchThree, INPUT);

    digitalWrite(ledOne, LOW);
    digitalWrite(ledTwo, LOW);

    ledOneRequest.hostname       = "alecrippberger.com";
    ledOneRequest.path           = "/particle-api/wp-json/particle-api/v1/light/green";
    ledOneRequest.port           = 80;

    ledTwoRequest.hostname       = "alecrippberger.com";
    ledTwoRequest.path           = "/particle-api/wp-json/particle-api/v1/light/red";
    ledTwoRequest.port           = 80;

    switchOneRequest.hostname    = "alecrippberger.com";
    switchOneRequest.path        = "/particle-api/wp-json/particle-api/v1/switch/1";
    switchOneRequest.port        = 80;

    switchTwoRequest.hostname    = "alecrippberger.com";
    switchTwoRequest.path        = "/particle-api/wp-json/particle-api/v1/switch/2";
    switchTwoRequest.port        = 80;

    switchThreeRequest.hostname  = "alecrippberger.com";
    switchThreeRequest.path      = "/particle-api/wp-json/particle-api/v1/switch/3";
    switchThreeRequest.port      = 80;

}

void loop() {

    // Request path and body can be set at runtime or at setup.
    unsigned long now = millis();

    if ((now - lastPublish) < publish_delay) {
        // it hasn't been 10 seconds yet...
        return;
    }

    if (nextTime > millis()) {
        return;
    }

    nextTime = millis() + 10000;

    Serial.println("10 seconds passed.");

    // Get LED one status and update
    http.get(ledOneRequest, response, headers);
    ledUpdated(ledOne, response.body);
    delay(100);

    // Get LED one status and update
    http.get(ledTwoRequest, response, headers);
    ledUpdated(ledTwo, response.body);
    delay(100);

    makeRequest("put", "switch/1", statusToString(digitalRead(switchOne)), "Switch One");
    delay(100);
    makeRequest("put", "switch/2", statusToString(digitalRead(switchTwo)), "Switch Two");
    delay(100);
    makeRequest("put", "switch/3", statusToString(digitalRead(switchThree)), "Switch Three");
    delay(100);


    lastPublish = now;
}

void makeRequest(String verb, String path, String body, String name) {

    http_request_t request;

    request.hostname             = "alecrippberger.com";
    request.path                 = "/particle-api/wp-json/particle-api/v1/" + String(path);
    request.port                 = 80;
    request.body                 = String(body);

    Serial.print("Attempting to " + String(verb) + " to: ");
    Serial.println(String(request.hostname) + String(request.path));

    if (verb == "post") {
        http.post(request, response, headers);
    }
    else if (verb == "put") {
        http.put(request, response, headers);
    }
    else if (verb == "get") {
        http.get(request, response, headers);
    }
    else if (verb == "delete") {
        http.del(request, response, headers);
    } else {

    }


    Serial.print( String(name) + " " + String(verb) + " Response Status: ");
    Serial.println(response.status);
    Serial.print( String(name) + " " + String(verb) + " Response Body: ");
    Serial.println(response.body);

}


void ledUpdated(int led, const char *data) {


    if ( strcmp( data, "{\"status\":\"false\"}" ) == 0 ) {
        // if your buddy's beam is intact, then turn your board LED off
        digitalWrite(led, LOW);
    }
    else if ( strcmp( data, "{\"status\":\"true\"}" ) == 0 ) {
        // if your buddy's beam is broken, turn your board LED on
        digitalWrite(led, HIGH);
    }
    else {
        // if the data is something else, don't do anything.
        // Really the data shouldn't be anything but those two listed above.
    }
}

String statusToString(bool status) {

    if (status) {
        return "{\"status\":\"true\"}";
    }

    return "{\"status\":\"false\"}";

}
