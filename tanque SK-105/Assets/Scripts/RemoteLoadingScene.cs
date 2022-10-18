using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using TMPro;

using Random = UnityEngine.Random;
using System.Globalization;
using TankSimulator.Core;

///
/// Tips sacados de: https://github.com/jleahred/ortograph/blob/master/data/frases%20c%C3%A9lebres.txt
///
public class RemoteLoadingScene : MonoBehaviour
{

    [SerializeField]
    private bool isServer;

    [SerializeField]
    private GameObject loadingScreen;

    [SerializeField]
    private CanvasGroup alphaCanvas, loadingCanvasGroup;

    [SerializeField]
    private TextMeshProUGUI tipText;

    [SerializeField]
    private Vector2 timeBetweenTips;

    [SerializeField]
    private List<string> tips;

    [SerializeField]
    private GameObject mainMenuCamera = null; 

    [SerializeField, Header("Debug")]
    private bool debug;

    private SceneLoader sceneLoader = null;
    private int tipCount;

    #region Unity Methods

    private void Awake()
    {
        sceneLoader = new SceneLoader(); 
    }

    void Start()
    {
        // ApiHelper.SetState((int) States.Low);
        TCPManager.CreateTCPInstance(isServer);
        StartCoroutine(GenerateTips());
        StartCoroutine(LoadScene());
    }

    #endregion

    IEnumerator LoadScene()
    {
        yield return new WaitForSeconds(2f);
        SetStart stateResponse = null;
        int state = -1;

        if (!debug)
        {
            while (state != (int)States.Start || state == -1)
            {
                try
                {
                    stateResponse = ApiHelper.LoadState();
                    state = int.Parse(stateResponse.value, CultureInfo.InvariantCulture);
                    print($"Calling API \"{state}\"");
                }

                catch (Exception _e)
                {
                    state = -1;
                }

                yield return new WaitForSeconds(1f);
            }

            ApiHelper.SetState((int)States.Low);
            UserData.RoomSetting = ApiHelper.GetRoomSetting();
        }

        print($"IsServer: {TCPManager.Instance.isServer}");
        //SceneManager.LoadScene(1);
        sceneLoader.LoadScene(UserData.RoomSetting.selectedSceneName, (loadSene) => 
        {
            loadingScreen.SetActive(false);
            mainMenuCamera.SetActive(false); 
        }); 
    }

    IEnumerator GenerateTips()
    {
        tipCount = Random.Range(0, tips.Count);
        tipText.text = tips[tipCount];

        yield return new WaitForSeconds(1.5f);
        LeanTween.alphaCanvas(loadingCanvasGroup, 1f, 0.5f).setEase(LeanTweenType.easeInOutQuad);
        LeanTween.alphaCanvas(alphaCanvas, 1f, 0.5f).setEase(LeanTweenType.easeInOutQuad);
        yield return new WaitForSeconds(1f);
        while (loadingScreen.activeInHierarchy)
        {
            yield return new WaitForSeconds(Random.Range(timeBetweenTips.x, timeBetweenTips.y));

            LeanTween.alphaCanvas(alphaCanvas, 0f, 0.5f).setEase(LeanTweenType.easeInOutQuad);

            yield return new WaitForSeconds(.5f);

            tipCount = Random.Range(0, tips.Count);
            tipText.text = tips[tipCount];

            LeanTween.alphaCanvas(alphaCanvas, 1f, 0.5f).setEase(LeanTweenType.easeInOutQuad);
        }

    }
}
