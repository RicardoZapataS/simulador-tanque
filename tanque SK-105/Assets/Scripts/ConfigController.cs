using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using TMPro;

public class ConfigController : MonoBehaviour {
    [SerializeField] TMP_Dropdown dropdown;
    [SerializeField] TMP_Dropdown dropdownDificulty;
    [SerializeField] List<BulletData> bulletDatas;
    
    Dificulty dificulty;
    TypeBullet TypeAmmunition = TypeBullet.CargaHueca;
    
    void Start() {
        dropdown.onValueChanged.AddListener(value => {
            TypeAmmunition = (TypeBullet) value;
            UserData.BulletData = bulletDatas[value];
        });

        dropdownDificulty.onValueChanged.AddListener(value => {
            dificulty = (Dificulty) value;
            UserData.Dificulty = (Dificulty) value;
        });
    }

}
