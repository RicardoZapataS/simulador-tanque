using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class RemoteSettingMananger : MonoBehaviour
{ 
    [SerializeField] 
    private Material[] tankMaterials = new Material[2];
    [SerializeField] 
    private Transform[] tankPlaces = new Transform[5];
    [SerializeField] 
    private Transform playerTankTransform = null;
    [SerializeField] 
    private RoomSetting roomSetting = null;
    [SerializeField] 
    public GameObject pauseMenu = null;
    [SerializeField] 
    private float waitingTime = 1;

    void Awake()
    {
        roomSetting = ApiHelper.GetRoomSetting();
        StartCoroutine(pause());
        Debug.Log(roomSetting.isRandomPosition);
        InitiateParameters();
    } 
    private IEnumerator pause(){
        SetStart state = null;
        while(true){
            yield return new WaitForSeconds(waitingTime);
            state = ApiHelper.LoadState(); 
            if (state.value == States.Pause) 
            {
                ApiHelper.SetState(States.ConfirmPause); 
                pauseMenu.SetActive(true);
            }
            else if (state.value == States.Unpause) 
            {
                ApiHelper.SetState(States.Low); 
                pauseMenu.SetActive(false);
        
            }
        }
    }
    private void InitiateParameters(){
        Color colorRGB = new Color(); 
        if(ColorUtility.TryParseHtmlString(roomSetting.tankColor, out Color color))
        {
            colorRGB = color; 
        }
        Debug.Log(colorRGB);
        foreach (Material material in tankMaterials)
        {
            material.SetColor("_BaseColor", colorRGB);
        }

        if (roomSetting.isRandomPosition == 1)
        {
            playerTankTransform.position = tankPlaces[Random.Range(0, tankPlaces.Length)].position;
        }
    }
}
