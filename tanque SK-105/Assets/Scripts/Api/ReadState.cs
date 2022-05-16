using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class ReadState : MonoBehaviour {

    // Update is called once per frame
    void Update() {
        SetStart state = ApiHelper.LoadState();
        if (state.value == "2") {
            ApiHelper.Start();
            Debug.Log("Start: " + state.value);
            LoadNextScene();
        }
    }

    public void LoadNextScene() {
        SceneManager.LoadScene(SceneManager.GetActiveScene().buildIndex + 1);
    }
}
