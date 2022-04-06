using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class ConfigController : MonoBehaviour
{
    public string TypeAmmunition = "Carga hueca";
    
    // Start is called before the first frame update
    void Start()
    {
        var dropdown = transform.GetComponent<Dropdown>();
            
        dropdown.options.Clear();

        List<string> items = new List<string>();

        items.Add("Carga Hueca");
        items.Add("Alto poder explosivo");
        items.Add("Ejercicio");

        foreach(var item in items){
            dropdown.options.Add(new Dropdown.OptionData() { text = item});
        }
        DropDownItemSelected(dropdown);
        dropdown.onValueChanged.AddListener(delegate {DropDownItemSelected(dropdown);});
    }

    void DropDownItemSelected(Dropdown dropdown){
        int index = dropdown.value;

        TypeAmmunition = dropdown.options[index].text;
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
