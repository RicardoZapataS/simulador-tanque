# Importing Libraries
import serial
from pynput.keyboard import Key, Controller

keyboard = Controller()
arduino = serial.Serial(port='COM9', baudrate=115200, timeout=.1)
def write_read():
    data = arduino.readline()
    return data
while True:
    value = str(write_read())
    if "A" in value: 
        keyboard.press("A")
        keyboard.release("A")
        print(value) # printing the value
    if "S" in value: 
        keyboard.press("S")
        keyboard.release("S")
        print(value) # printing the value
    if "D" in value: 
        keyboard.press("D")
        keyboard.release("D")
        print(value) # printing the value
    if "W" in value: 
        keyboard.press("W")
        keyboard.release("W")
        print(value) # printing the value
    
    