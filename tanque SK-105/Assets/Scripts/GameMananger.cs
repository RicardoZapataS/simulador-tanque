using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class GameMananger : MonoBehaviour
{
    private string _currentLevelName;
    private List<AsyncOperation> _loadOperations;
    [SerializeField]
    private GameObject _canvasMainMenu = default;
    [SerializeField]
    private GameObject _dummyCamera = default;

    private void Start()
    {
        DontDestroyOnLoad(this.gameObject); 
        _loadOperations = new List<AsyncOperation>(); 
    }

    public void OnLoadOperationComplete(AsyncOperation ao)
    {
        if(_loadOperations.Contains(ao))
        {
            _loadOperations.Remove(ao); 
        }

        if(_currentLevelName != "MainMenu")
        {
            _canvasMainMenu.SetActive(false);
            _dummyCamera.SetActive(false);
        }
        Debug.Log("Scene loaded successfully.");
    }

    public void OnUnloadOperationComplete(AsyncOperation ao)
    {
        if(_loadOperations.Contains(ao))
        {
            _loadOperations.Remove(ao);
        }
        _canvasMainMenu.SetActive(true);
        _dummyCamera.SetActive(true);
        Debug.Log("Scene unloaded successfully."); 
    }

    public void LoadScene(string levelName)
    {
        AsyncOperation ao = SceneManager.LoadSceneAsync(levelName, LoadSceneMode.Additive); 
        if(ao == null)
        {
            Debug.LogError("[GameManager]The scene " + levelName + " does not exist."); 
            return; 
        }

        ao.completed += OnLoadOperationComplete;
        _loadOperations.Add(ao); 
        _currentLevelName = levelName; 
    }

    public void UnloadScene(string levelName)
    {
        AsyncOperation ao = SceneManager.UnloadSceneAsync(levelName); 
        if(ao == null)
        {
            Debug.LogError("[GameManager]The scene " + levelName + " does not exist.");
            return; 
        }
        ao.completed += OnUnloadOperationComplete;
        _loadOperations.Add(ao); 
    }

    public void ReloadLevel(string levelName)
    {
        UnloadScene(levelName);
        LoadScene(levelName);
    }

    public void QuitApplication()
    {
        Application.Quit();
    }
}
