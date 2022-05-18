using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using TMPro;

using Random = UnityEngine.Random;

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
        TCPManager.CreateTCPInstance();
        StartCoroutine(GenerateTips());
        StartCoroutine(LoadScene());
    }

    IEnumerator LoadScene() {
        yield return new WaitForSeconds(2f);
        SetStart stateResponse = null;
        string state = "";

        while (state != "2" || string.IsNullOrEmpty(state)) {
            try {
                stateResponse = ApiHelper.LoadState();
                state = stateResponse.value;
                print($"Calling API \"${state}\"");
            } catch (Exception _e) {
                state = "";
            }
            yield return new WaitForSeconds(1f);
        }
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
