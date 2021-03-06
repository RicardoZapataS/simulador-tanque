using System.Collections;
using System.Globalization;
using UnityEngine;
using TMPro;
using Random = UnityEngine.Random;
using UnityEngine.SceneManagement;

public class RoomManager : MonoBehaviour {
    [SerializeField] Transform tankPlayer;
    [SerializeField] Transform[] tankObjetives;
    [SerializeField] Transform[] tanksPositions;
    [SerializeField] Material[] tankObjetiveMaterials;
    [SerializeField] RoomSetting settings;

    [Header("UI Timing")]
    [SerializeField] TextMeshProUGUI timeText;

    [Header("UI")]
    [SerializeField] GameObject pauseMenu;
    [SerializeField] TextMeshProUGUI pauseText;
    [SerializeField] float waitingTime = 2f;
    [Header("Debug Section")]
    [SerializeField] bool debug;


    Color tankColor;
    [HideInInspector] public int currentTime, maxTime;
    public bool endGame = false;
    public bool pauseGame = false;
    public static RoomManager Main;

    void Awake() {
        Main = this;
        settings = UserData.RoomSetting;

        // Set Color
        if (ColorUtility.TryParseHtmlString(settings.tankColor, out tankColor)) {
            foreach (var material in tankObjetiveMaterials)
                material.color = tankColor;
        }

        // Set Scale
        foreach (var tankObjetive in tankObjetives) {
            print(tankObjetive.localScale);
            print(settings.tankSize);
            tankObjetive.localScale = Vector3.one * settings.tankSize;
        }

        // Change the player distance
        if (settings.isRandomPosition != 1) { // Is random
            Transform newPos = tanksPositions[Random.Range(0, tanksPositions.Length - 1)];
            tankPlayer.SetParent(newPos);
            tankPlayer.rotation = Quaternion.identity;
        }

        // Controll Time Text
        timeText.gameObject.SetActive(TCPManager.Main.isServer);
        if (!string.IsNullOrEmpty(settings.TimeSimulator) || !string.IsNullOrWhiteSpace(settings.TimeSimulator) || settings.TimeSimulator != "00:00")
            StartCoroutine(GameTimer());
        else
            timeText.gameObject.SetActive(false);

        // Initialize Pause Verification
        StartCoroutine(pause());
    } 
    private IEnumerator pause(){
        while (true){
            yield return new WaitForSeconds(waitingTime);
            int state = int.Parse(ApiHelper.LoadState().value, CultureInfo.InvariantCulture);
            if (state == (int) States.Pause) {
                pauseGame = true;
                ApiHelper.SetState((int) States.ConfirmPause); 
                pauseMenu.SetActive(true);
                pauseText.text = "Se ha pausado la simulacion";
            }
            else if (state == (int) States.Unpause) {
                pauseGame = false;
                ApiHelper.SetState((int) States.Low); 
                pauseMenu.SetActive(false);
                pauseText.text = ""; 
            } else if (state == (int) States.EndSimulation) {
                endGame = true;
                pauseMenu.SetActive(true);
                pauseText.text = "La simulacion a finalizado";
            } else if (state == (int) States.ConfirmEndSimulation) {
                // confirmamos el cambio de scena
                SceneManager.LoadScene(0);
            }
        }
    }

    IEnumerator GameTimer() {
        if (settings.TimeSimulator == "00:00") {
            currentTime = 0;
            while (!endGame) {
                if (!pauseGame) currentTime++;
                yield return new WaitForSeconds(1f);
                int min = currentTime / 60;
                int secs = currentTime % 60;
                timeText.text = $"{min}:{secs}";
            }
        } else {
            string[] time = settings.TimeSimulator.Split(':');
            (int min, int secs) = (int.Parse(time[0], CultureInfo.InvariantCulture), int.Parse(time[1], CultureInfo.InvariantCulture));
            currentTime = 0;
            maxTime = (min * 60) + secs;

            int alertPercentage = (60 * maxTime) / 100; // 40% es una advertencia de color
            int dangerPercentage = (30 * maxTime) / 100; // 20% indica peligro en el tiempo restante

            // Using count
            while (currentTime < maxTime && !endGame) {
                yield return new WaitForSeconds(1f);
                if (!pauseGame) currentTime++;

                // if (currentTime == alertPercentage)
                //     LeanTween.value(timeLineFillImage.gameObject, timeLineFillImage.color, alertColor, 2f).setOnUpdate(val =>
                //         timeLineFillImage.color = val
                //     );

                // if (currentTime == dangerPercentage)
                //     LeanTween.value(timeLineFillImage.gameObject, timeLineFillImage.color, dangerColor, 2f).setOnUpdate(val =>
                //         timeLineFillImage.color = val
                //     );
            }

            // Llamada a la finalizacion de la simulacion
            endGame = true;
        }
        StartCoroutine(EndSimulation());
    }

    public void EndGame() {
        endGame = true;
        StartCoroutine(EndSimulation());
    }

    // TODO: pantalla final que espera un estado para pasar al menu
    // Pantall de "Simulacion Finalizada"
    IEnumerator EndSimulation () {
        pauseMenu.SetActive(true);
        pauseText.text = "La simulacion a finalizado";
        yield return new WaitForSeconds(5f);
        SceneManager.LoadScene(0);
    }
}