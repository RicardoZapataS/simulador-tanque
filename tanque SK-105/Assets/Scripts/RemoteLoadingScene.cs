using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using TMPro;

using Random = UnityEngine.Random;
using System.Globalization;

///
/// Tips sacados de: https://github.com/jleahred/ortograph/blob/master/data/frases%20c%C3%A9lebres.txt
///
public class RemoteLoadingScene : MonoBehaviour {

    [SerializeField] GameObject loadingScreen;
    [SerializeField] CanvasGroup alphaCanvas, loadingCanvasGroup;
    [SerializeField] TextMeshProUGUI tipText;
    [SerializeField] Vector2 timeBetweenTips;
    [SerializeField] List<string> tips;

    void Start() {
        ApiHelper.SetState((int) States.Low);
        TCPManager.CreateTCPInstance();
        StartCoroutine(GenerateTips());
        StartCoroutine(LoadScene());
    }

    IEnumerator LoadScene() {
        yield return new WaitForSeconds(2f);
        SetStart stateResponse = null;
        int state = -1;

#if !UNITY_EDITOR
        while (state != States.Start || state == -1) {
#else
        if (state == -1) {
#endif
            try {
                stateResponse = ApiHelper.LoadState();
                state = int.Parse(stateResponse.value, CultureInfo.InvariantCulture);
                print($"Calling API \"{state}\"");
            } catch (Exception _e) {
                state = -1;
            }
            yield return new WaitForSeconds(1f);
        }
        ApiHelper.SetState((int) States.Low);
        UserData.RoomSetting = ApiHelper.GetRoomSetting();
        SceneManager.LoadScene(1);
    }

    int tipCount;
    IEnumerator GenerateTips() {
        tipCount = Random.Range(0, tips.Count);
        tipText.text = tips[tipCount];

        yield return new WaitForSeconds(1.5f);
        LeanTween.alphaCanvas(loadingCanvasGroup, 1f, 0.5f).setEase(LeanTweenType.easeInOutQuad);
        LeanTween.alphaCanvas(alphaCanvas, 1f, 0.5f).setEase(LeanTweenType.easeInOutQuad);
        yield return new WaitForSeconds(1f);
        while (loadingScreen.activeInHierarchy) {
            yield return new WaitForSeconds(Random.Range(timeBetweenTips.x, timeBetweenTips.y));

            LeanTween.alphaCanvas(alphaCanvas, 0f, 0.5f).setEase(LeanTweenType.easeInOutQuad);

            yield return new WaitForSeconds(.5f);

            tipCount = Random.Range(0, tips.Count);
            tipText.text = tips[tipCount];

            LeanTween.alphaCanvas(alphaCanvas, 1f, 0.5f).setEase(LeanTweenType.easeInOutQuad);
        }

    }
}
