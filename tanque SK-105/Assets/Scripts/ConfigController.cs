using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using TMPro;

public class ConfigController : MonoBehaviour {
    [SerializeField] TMP_Dropdown dropdown;
    [SerializeField] List<BulletData> bulletDatas;
    
    public TypeBullet TypeAmmunition = TypeBullet.CargaHueca;
    
    void Start() =>
        dropdown.onValueChanged.AddListener(value => {
            TypeAmmunition = (TypeBullet) value;
            UserData.BulletData = bulletDatas[value];
        });

}
