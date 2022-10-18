namespace TankSimulator.Core
{
    using System;
    using UnityEngine;
    using UnityEngine.SceneManagement;

    public class SceneLoader
    {
        public void LoadScene(string sceneName, Action<AsyncOperation> onSceneLoaded)
        {
            AsyncOperation loadScene = SceneManager.LoadSceneAsync(sceneName, LoadSceneMode.Additive);

            if (loadScene == null)
            {
                Debug.LogError($"The scene with the name {sceneName} was not loaded, please check that the name is correct or that the scene has been added to the build settings!");
                return;
            }

            loadScene.completed += onSceneLoaded;
            SceneManager.SetActiveScene(SceneManager.GetSceneByName(sceneName)); 
        }

        public void UnloadScene(string sceneName, Action<AsyncOperation> onSceneUnloaded)
        {
            AsyncOperation unloadScene = SceneManager.UnloadSceneAsync(sceneName);

            if (unloadScene == null)
            {
                Debug.LogError($"The scene with the name {sceneName} was not unloaded, please check that the name is correct or that the scene has been added to the build settings!");
                return;
            }

            unloadScene.completed += onSceneUnloaded;
        }
    }
}
