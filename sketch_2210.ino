
#define SEARCH_AFTER_RESET "ready"
#define INTRO "\r\n"
 
#define AP_NORMAL ""
#define PWD_NORMAL ""
#define HOST_NORMAL ""
#define PORT_NORMAL ""
 
#define AP_BOOTLOADER ""
#define PWD_BOOTLOADER ""
#define HOST_BOOTLOADER ""
#define PORT_BOOTLOADER ""
 
int sensor_temp_1 = 9;
int value_temp_1;
String device_id = "16";
boolean ok = false;
int counter = 0;

//-----------------------------------------------------------------------------------------------------------------------------------
/*
Parameters:
  command: The string to send.
  timeout: The maximum time in milliseconds the function can be running before a time out.
  wait_for1: The search string when the command succeeded.
  wait_for1: The search string when the command failed.
Returns: 
  The string contained in wait_for1, wait_for2 or the string TIMEOUT.
Description: 
  It sends the command trough the serial port and waits for one of the expected strings or exit with timeout
*/
String send(String command, int timeout, String wait_for1, String wait_for2)
{
  unsigned long time = millis();
  String received = "";
  
  Serial.print(command);
  Serial.print(INTRO);
  
  while(millis() < (time + timeout))
  {
    if(Serial.available() > 0)
    {
      received.concat(char(Serial.read()));
      if(received.indexOf(wait_for1) > -1)
      {
        return wait_for1;
      }
      else if(received.indexOf(wait_for2) > -1)
      {
        return wait_for2;
      }
    }
  }
  
  return "TIMEOUT";
}
//-----------------------------------------------------------------------------------------------------------------------------------
/*
Parameters:
  wait_for: The search string.
  timeout: The maximum time in milliseconds the function can be running before a time out.
Returns: 
  True if the string was found, otherwise False.
Description: 
  It waits for the expected string.
*/
boolean look_for(String wait_for, int timeout)
{
  unsigned long time = millis();
  String received = "";
  
  while(millis() < (time + timeout))
  {
    if(Serial.available() > 0)
    {
      received.concat(Serial.readString());
      if(received.indexOf(wait_for) > -1)
      {
        return true;
      }
    }
  }
  
  return false;
}
//-----------------------------------------------------------------------------------------------------------------------------------
/*
Parameters:
  command: The string to send.
  timeout: The maximum time in milliseconds the function can be running before a timeout.
  wait_for1: The search string when the command succeeded.
  wait_for1: The search string when the command failed.
Returns: 
  True if the wait_for1 string was found, otherwise False.
Description: 
  It sends the command trough the serial port and waits for one of the expected strings or exit with timeout.
*/
boolean send_command(String command, int timeout, String wait_for1, String wait_for2)
{
  String state;
  
  state = send(command, timeout, wait_for1, wait_for2);
  if(state == wait_for1)
  {
    return true;
  }
  else if(state == wait_for2)
  {
    return false;// do something on error
  }
  else
  {
    return false;// do something on timeout
  }
  
  return false;
}
//-----------------------------------------------------------------------------------------------------------------------------------
/*
Parameters:
  Nothing
Returns: 
  True if all commands were successfully, otherwise False.
Description: 
  It initializes the module, joins to the access point and connects to the server.
*/
boolean init_commands()
{
  if(send_command("AT+CWMODE=1", 5000, "OK", "ERROR"))
  {
    if (send_command("AT+RST", 5000, SEARCH_AFTER_RESET, "ERROR"))
    {
  
      String cwjap = "AT+CWJAP=\"";
      cwjap += AP_NORMAL;
      cwjap += "\",\"";
      cwjap += PWD_NORMAL;
      cwjap += "\"";
      if (send_command(cwjap, 20000, "OK", "FAIL"))
        if (send_command("AT+CIPMUX=0", 2000, "OK", "ERROR"))
          if (send_command("AT+CIPMODE=0", 2000, "OK", "ERROR"))
          {
            
            String cipstart = "AT+CIPSTART=\"UDP\",\"";
            cipstart += HOST_NORMAL;
            cipstart += "\",";
            cipstart += PORT_NORMAL;
            if (send_command(cipstart, 5000, "OK", "ERROR"))
              return true;
          }
    }
  }
            
  return false;
}
//-----------------------------------------------------------------------------------------------------------------------------------
/*
Parameters:
  Nothing
Returns: 
  True if all commands were successfully, otherwise False.
Description: 
  It initializes the module, joins to the access point, connects to the server and starts the protocol.
*/
boolean boot_commands()
{
  
  String cwjap = "AT+CWJAP=\"";
  cwjap += AP_BOOTLOADER;
  cwjap += "\",\"";
  cwjap += PWD_BOOTLOADER;
  cwjap += "\"";
  if (send_command(cwjap, 20000, "OK", "FAIL"))
    if (send_command("AT+CIPMUX=0", 2000, "OK", "ERROR"))
      if (send_command("AT+CIPMODE=1", 2000, "OK", "ERROR"))
      {
        
        String cipstart = "AT+CIPSTART=\"UDP\",\"";
        cipstart += HOST_BOOTLOADER;
        cipstart += "\",";
        cipstart += PORT_BOOTLOADER;
        if (send_command(cipstart, 5000, "OK", "ERROR"))
          if (send_command("AT+CIPSEND", 3000, ">", "ERROR"))
          
            if (send_command("hello", 2000, "welcome", "error"))
                if (send_command("sketch_jun15a.cpp.hex", 2000, "ok", "error")){
                  return true;
                }
              
           
         
      }
            
  return false;
}
//-----------------------------------------------------------------------------------------------------------------------------------
/*
Parameters:
  Nothing
Returns: 
  True if all commands were successfully, otherwise False.
Description: 
  It sends a string to the remote host and show it in the display.
*/
boolean test()
{
  value_temp_1 = analogRead(sensor_temp_1);
  
  String temp_1 = String(value_temp_1);
  
  String command = "AT+CIPSEND=";
  String to_send = temp_1 + ","+ device_id;
  command += to_send.length() + 2;
  
  if (send_command(command, 2000, ">", "ERROR"))
    if (send_command(to_send + "\r\n", 2000, "OK", "ERROR"))
    {
      
      counter++;
      return true;
    }
  
  return false;
}
//-----------------------------------------------------------------------------------------------------------------------------------
void setup()
{
  pinMode(13, OUTPUT);
  Serial.begin(115200);
  
  
  // Remove any garbage from the RX buffer
  delay(3000);
  while(Serial.available() > 0) Serial.read();
  send_command("AT+CIPSTA=\"192.168.1.55\",\"192.168.1.1\",\"255.255.255.0\"",2000, "OK","ERROR");
  ok = init_commands();
  
}
//-----------------------------------------------------------------------------------------------------------------------------------
void loop()
{
  if(ok)
  {
    digitalWrite(13, HIGH);
    ok = test();
    if(ok && look_for("reboot", 10000))
    {
      if(boot_commands())
      {
       pinMode(12, OUTPUT);
       // send_command("AT+CIPSEND=7", 2000, ">", "ERROR");
       // send_command("goodbye", 2000, "OK", "ERROR");
        //send_command("AT+CIPSEND=1", 2000, ">", "ERROR");
        //send_command("\x00", 2000, "OK", "ERROR");
        
        digitalWrite(12, LOW);
        for(;;);
      }
      else
      {
        ok = false;
      }
    }
  }  
  else
  {
    digitalWrite(13, LOW);
    
    for(;;);
  }
}
