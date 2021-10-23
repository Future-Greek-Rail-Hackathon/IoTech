#include <Sodaq_RN2483.h>

#define debugSerial SerialUSB
#define loraSerial Serial2

#define NIBBLE_TO_HEX_CHAR(i) ((i <= 9) ? ('0' + i) : ('A' - 10 + i))
#define HIGH_NIBBLE(i) ((i >> 4) & 0x0F)
#define LOW_NIBBLE(i) (i & 0x0F)

volatile byte state = LOW;
int counter_lat_lon=0;
double lat[]={40.655,40.688333,40.674444,40.673611,40.636667,40.491667,40.450556,40.443611,40.379167,40.316667,40.262778,40.226111,40.124167,40.058611,40.009722,39.972222,39.950278,39.899444,39.873889,39.8525,39.785,39.703056,39.629722,39.601111,39.513333,39.464444,39.416944,39.311667,39.24,39.178889,38.607778,38.534167,38.471667,38.393056,38.373056,38.365,38.330556,38.329722,38.367778,38.372778,38.361111,38.323333,38.249444,38.235278,38.228889,38.203333,38.188056,38.139444,38.123611,38.08,38.068889,38.019444,37.988333,37.961111};
double lon[]={22.91,22.850278,22.803889,22.601667,22.530278,22.559167,22.577222,22.585,22.613889,22.578056,22.530278,22.541389,22.550556,22.565833,22.5925,22.645278,22.660556,22.615278,22.548333,22.518333,22.4925,22.459722,22.425278,22.394167,22.336389,22.2825,22.231944,22.243611,22.266944,22.286667,22.718333,22.811944,22.926667,23.004167,23.150833,23.164444,23.26,23.319444,23.382778,23.471111,23.518333,23.608333,23.695833,23.785556,23.8375,23.851944,23.844722,23.858333,23.8325,23.744167,23.7375,23.718056,23.719444,23.6625};
//Use OTAA, set to false to use ABP
bool OTAA = true;

// ABP
// USE YOUR OWN KEYS!
const uint8_t devAddr[4] =
{
    0x00, 0x00, 0x00, 0x00
};

// USE YOUR OWN KEYS!
const uint8_t appSKey[16] =
{
  0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x10, 0x10, 0x00, 0x10, 0x00, 0x00, 0x00
};

// USE YOUR OWN KEYS!
const uint8_t nwkSKey[16] =
{
  0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00
};

// OTAA
// With using the GetHWEUI() function the HWEUI will be used
static uint8_t DevEUI[8]
{
    0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00
};


const uint8_t AppEUI[8] =
{
    0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x10, 0x10
};

const uint8_t AppKey[16] =
{
    0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x10, 0x10
};

void setup()
{
  delay(1000);

  while ((!debugSerial) && (millis() < 10000)){
    // Wait 10 seconds for debugSerial to open
  }
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(BUTTON, INPUT_PULLUP);
   attachInterrupt(digitalPinToInterrupt(BUTTON), pressed, CHANGE);
  debugSerial.println("Start");

  // Start streams
  debugSerial.begin(57600);
  loraSerial.begin(LoRaBee.getDefaultBaudRate());

  LoRaBee.setDiag(debugSerial); // to use debug remove //DEBUG inside library
  LoRaBee.init(loraSerial, LORA_RESET);

  //Use the Hardware EUI
  getHWEUI();

  // Print the Hardware EUI
  debugSerial.print("LoRa HWEUI: ");
  for (uint8_t i = 0; i < sizeof(DevEUI); i++) {
      debugSerial.print((char)NIBBLE_TO_HEX_CHAR(HIGH_NIBBLE(DevEUI[i])));
      debugSerial.print((char)NIBBLE_TO_HEX_CHAR(LOW_NIBBLE(DevEUI[i])));
  }
  debugSerial.println();  

  setupLoRa();
}

void setupLoRa(){
  if(!OTAA){
    // ABP
    setupLoRaABP();
  } else {
    //OTAA
    setupLoRaOTAA();
  }
  // Uncomment this line to for the RN2903 with the Actility Network
  // For OTAA update the DEFAULT_FSB in the library
  // LoRaBee.setFsbChannels(1);

  LoRaBee.setSpreadingFactor(11);
}

void setupLoRaABP(){  
  if (LoRaBee.initABP(loraSerial, devAddr, appSKey, nwkSKey, true))
  {
    debugSerial.println("Communication to LoRaBEE successful.");
  }
  else
  {
    debugSerial.println("Communication to LoRaBEE failed!");
  }
}

void setupLoRaOTAA(){

  if (LoRaBee.initOTA(loraSerial, DevEUI, AppEUI, AppKey, true))
  {
    debugSerial.println("Network connection successful.");
  }
  else
  {
    debugSerial.println("Network connection failed!");
  }
}

void loop()
{
   String reading_temp = getTemperature();
   debugSerial.println(reading_temp);
   String reading_piezo = getPiezo();
   debugSerial.println(reading_piezo);
   //String lat="38.814447";
   //String lon="22.609966";
   String payload=reading_temp+";"+reading_piezo+";"+String(lat[counter_lat_lon])+";"+String(lon[counter_lat_lon])+";"+String(state)+";";
    debugSerial.println(payload);
    counter_lat_lon=counter_lat_lon+1;
    if(counter_lat_lon>54){
      counter_lat_lon=0;
    }
    switch (LoRaBee.send(1, (uint8_t*)payload.c_str(), payload.length()))
    {
    case NoError:
      debugSerial.println("Successful transmission.");
      digitalWrite(LED_BUILTIN, HIGH);   // turn the LED on (HIGH is the voltage level)
      delay(100);                       
      digitalWrite(LED_BUILTIN, LOW);    // turn the LED off by making the voltage LOW
      delay(100);  
      state=LOW;        
      break;
    case NoResponse:
      debugSerial.println("There was no response from the device.");
      break;
    case Timeout:
      debugSerial.println("Connection timed-out. Check your serial connection to the device! Sleeping for 20sec.");
      delay(20000);
      break;
    case PayloadSizeError:
      debugSerial.println("The size of the payload is greater than allowed. Transmission failed!");
      break;
    case InternalError:
      debugSerial.println("Oh No! This shouldn't happen. Something is really wrong! The program will reset the RN module.");
      setupLoRa();
      break;
    case Busy:
      debugSerial.println("The device is busy. Sleeping for 10 extra seconds.");
      delay(10000);
      break;
    case NetworkFatalError:
      debugSerial.println("There is a non-recoverable error with the network connection. The program will reset the RN module.");
      setupLoRa();
      break;
    case NotConnected:
      debugSerial.println("The device is not connected to the network. The program will reset the RN module.");
      setupLoRa();
      break;
    case NoAcknowledgment:
      debugSerial.println("There was no acknowledgment sent back!");
      break;
    default:
      break;
    }
    // Delay between readings
    // 60 000 = 1 minute
    delay(10000); 
    
}

String getTemperature()
{
  //10mV per C, 0C is 500mV
  float mVolts = (float)analogRead(TEMP_SENSOR) * 3300.0 / 1023.0;
  float temp = (mVolts - 500.0) / 10.0;

  return String(temp);
}

String getPiezo(){
  // Read Piezo ADC value in, and convert it to a voltage
  int piezoADC = analogRead(A3);
  float piezoV = piezoADC/ 1023.0 * 5.0;
  Serial.println(piezoV); // Print the voltage.
  delay(250);
  return String(piezoV);
}

void pressed(){
  debugSerial.println("Button Pressed");
  state = HIGH;  
}
/**
* Gets and stores the LoRa module's HWEUI/
*/
static void getHWEUI()
{
    uint8_t len = LoRaBee.getHWEUI(DevEUI, sizeof(DevEUI));
}
