using System.Collections;
using System.Globalization;
using System.Runtime;
using System.Threading.Tasks;
using UnityEngine;
using UnityEngine.UI;
using Random = UnityEngine.Random;

public class RoomManager : MonoBehaviour {
    [SerializeField] Transform tankPlayer;
    [SerializeField] Transform[] tankObjetives;
    [SerializeField] Material[] tankObjetiveMaterials;
    [SerializeField] Vector2 randomValuesX;
    [SerializeField] Vector2 randomValuesZ;
    [SerializeField] RoomSetting settings;

    [Header("UI Timing")]
    [SerializeField] RectTransform timeLineBG;
    [SerializeField] RectTransform timeLineFill;
    [SerializeField] Image timeLineFillImage;
    [SerializeField] Color alertColor;
    [SerializeField] Color dangerColor;


    Color tankColor;
    Vector3 tankPosition;
    void Awake() {
        settings = UserData.RoomSetting;
        // Settings from server
        // 
        //  tankColor = "#27B887",
        //  isRandomPosition = 1,
        //  tankSize = 8,
        //  ammountBullet = 5,
        //  targetDistance = 1000,
        //  TimeSimulator = "05:00"
        //

        // Set Color
        if (ColorUtility.TryParseHtmlString(settings.tankColor, out tankColor)) {
            foreach (var material in tankObjetiveMaterials)
                material.color = tankColor;
        }

        // Set Scale
        foreach (var tankObjetive in tankObjetives) {
            print(tankObjetive.localScale);
            print(settings.tankSize);
            tankObjetive.localScale = Vector3.one * (tankObjetive.transform.localScale.x * settings.tankSize);
        }

        tankPosition = tankPlayer.position;
        // Change the player distance
        if (settings.isRandomPosition == 1) // Is not random
            tankPosition.x = settings.targetDistance * -1;
        else { // is random
            tankPosition.x = Random.Range(randomValuesX.x, randomValuesX.y);
            tankPosition.z = Random.Range(randomValuesZ.x, randomValuesZ.y);
        }

        RaycastHit hit;
        if (Physics.Raycast(tankPlayer.position, tankPlayer.up, out hit, Mathf.Infinity)) {
            tankPosition.y = hit.point.y + 1f;
            Debug.DrawRay(tankPlayer.position, tankPlayer.up * hit.distance, Color.white);
            Debug.Log("Did Hit");
        }
        else if (Physics.Raycast(tankPlayer.position, tankPlayer.up * -1, out hit, Mathf.Infinity)) {
            tankPosition.y = hit.point.y + 1f;
            Debug.DrawRay(tankPlayer.position, tankPlayer.up * -1 * hit.distance, Color.yellow);
            Debug.Log("Did Hit");
        }
        tankPlayer.position = tankPosition;

        if (!string.IsNullOrEmpty(settings.TimeSimulator) || !string.IsNullOrWhiteSpace(settings.TimeSimulator))
            StartCoroutine(GameTimer());
        else
            timeLineBG.gameObject.SetActive(false);
    }

    IEnumerator GameTimer() {
        string[] time = settings.TimeSimulator.Split(':');
        (int min, int secs) = (int.Parse(time[0], CultureInfo.InvariantCulture), int.Parse(time[1], CultureInfo.InvariantCulture));
        int currentTime, maxTime;
        currentTime = maxTime = (min * 60) + secs;
        float maxSize = timeLineFill.rect.width;

        int alertPercentage = (60 * maxTime) / 100; // 40% es una advertencia de color
        int dangerPercentage = (30 * maxTime) / 100; // 20% indica peligro en el tiempo restante

        print($"{currentTime} - {alertPercentage} - {dangerPercentage}");

        // Using count
        while (currentTime > 0) {
            yield return new WaitForSeconds(1f);
            currentTime--;
            // timeLineFill.SetSizeWithCurrentAnchors(RectTransform.Axis.Horizontal, (currentTime * maxSize) / maxTime);
            LeanTween.value(gameObject, timeLineFill.rect.width, (currentTime * maxSize) / maxTime, 1f).setOnUpdate(val =>
                timeLineFill.SetSizeWithCurrentAnchors(RectTransform.Axis.Horizontal, val)
            );

            if (currentTime == alertPercentage)
                LeanTween.value(timeLineFillImage.gameObject, timeLineFillImage.color, alertColor, 2f).setOnUpdate(val =>
                    timeLineFillImage.color = val
                );

            if (currentTime == dangerPercentage)
                LeanTween.value(timeLineFillImage.gameObject, timeLineFillImage.color, dangerColor, 2f).setOnUpdate(val =>
                    timeLineFillImage.color = val
                );
        }
    }
}