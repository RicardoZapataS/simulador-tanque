using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Canyon : MonoBehaviour
{
    [SerializeField, Range(0, 1000)]
    private int _distance = 1;
    [SerializeField]
    private GameObject _projectilePrefab;
    [SerializeField]
    private Transform _shootingPoint; 
    [SerializeField] AudioClip shootSound;

    AudioSource audioSource;

    [SerializeField]
    float smooth = 5.0f;

    void Start() {
        audioSource = GetComponent<AudioSource>();
    }

    private void Update()
    {
        if(Input.GetKeyDown(KeyCode.Space))
        {
            ShootProjectile(); 
        }
        float x = Input.GetAxis("Horizontal");

        if (x != 0)
        {
            transform.Rotate(Vector3.up * smooth * Time.deltaTime * x, Space.World); 
        }

        float y = Input.GetAxis("Vertical"); 

        if(y!=0)
        {
            transform.Rotate(Vector3.forward * smooth * Time.deltaTime * y, Space.World);
        }
    }

    private void ShootProjectile()
    {
        GameObject projectile = Instantiate(_projectilePrefab, _shootingPoint.position, Quaternion.identity); 
        Rigidbody projectileRigidbody = null; 
        if(projectile.GetComponent<Rigidbody>() != null)
        {
            projectileRigidbody = projectile.GetComponent<Rigidbody>();
        }

        projectileRigidbody.velocity = transform.up * _distance;   
        audioSource?.PlayOneShot(shootSound);
        Destroy(projectile, 15);
    }
    
    private void OnDrawGizmos()
    {
        Debug.DrawLine(transform.position, transform.position + transform.up * _distance); 
    }
    public void RotateCanyon(Vector3 axis, float angle)
    {
        Quaternion target = transform.rotation * Quaternion.AngleAxis(angle, axis);
        transform.rotation = target;
    }
}
