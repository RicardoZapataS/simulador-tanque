using System;
using UnityEngine;

[Serializable]
public class RemoteBulletData {
    public TypeBullet typeBullet;
    public float initialVelocity, weight;
    public Vector3 position, scale, rotation;

    public static implicit operator BulletData(RemoteBulletData d) => new BulletData {
        typeBullet = d.typeBullet,
        initialVelocity = d.initialVelocity,
        weight = d.weight,

    };
}

[Serializable]
public class BulletData {
    public TypeBullet typeBullet;
    public float initialVelocity, weight;

    public BulletData() {}

    public BulletData(float initialVelocity, float weight) {
        this.initialVelocity = initialVelocity;
        this.weight = weight;
    }
}
