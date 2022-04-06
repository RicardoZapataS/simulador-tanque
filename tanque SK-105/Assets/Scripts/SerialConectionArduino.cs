using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System.IO.Ports;
using System;

public class SerialConectionArduino : MonoBehaviour
{
    SerialPort stream = new SerialPort("COM5", 9600);

    [SerializeField]
    private GameObject _torreta;

     [SerializeField, Range(0, 150)]
    private int _muescas = 30;

    int ant = 0;

    // Start is called before the first frame update
    void Start()
    {
        stream.Open();
        stream.ReadTimeout = 100;
    }

    // Update is called once per frame
    void Update()
    {
       if(stream.IsOpen){
            string valorEntradaArduinoTexto = stream.ReadLine();
            //Debug.Log(valorEntradaArduinoTexto);
            string[] split = valorEntradaArduinoTexto.Split('/');
            int rev = 400; // 800 rev = 360°
            float grado = 10f;
            Debug.Log(split[1]);
            if("CW" == split[0]){
                _torreta.transform.Rotate(new Vector3( 0f,0f,  grado * (Int32.Parse(split[1]) - ant)) * Time.deltaTime);
            }else{
                _torreta.transform.Rotate(new Vector3( 0f,0f,  -grado * (Int32.Parse(split[1]) - ant)) * Time.deltaTime);
            }
            ant = Int32.Parse(split[1]);
       }else if(Input.GetKeyDown(KeyCode.D)){
         
       }
    }
    IEnumerator Wait()
    {
        //To wait, type this:
    
        //Stuff before waiting
        yield return new WaitForSeconds(2);
        //Stuff after waiting.
    }
}