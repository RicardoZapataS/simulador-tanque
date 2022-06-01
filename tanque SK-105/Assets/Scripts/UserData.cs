public static class UserData {

    static BulletData bulletData;
    static Dificulty dificulty;

    static RoomSetting roomSetting = 
    #if UNITY_EDITOR
        new RoomSetting() {
            id = 6,
            tankColor = "#27B887",
            isRandomPosition = 1,
            tankSize = 4,
            ammountBullet = 5,
            targetDistance = 1000,
            TimeSimulator = "05:00"
        }
    #else
        null
    #endif
    ;

    public static BulletData BulletData {
        get => bulletData ?? new BulletData() {
            typeBullet = TypeBullet.Practica,
            initialVelocity = 800,
            weight = 17.3f
        };
        set => bulletData = value;
    }

    public static Dificulty Dificulty {
        get => dificulty;
        set => dificulty = value;
    }

    public static RoomSetting RoomSetting {
        get => roomSetting;
        set => roomSetting = value;
    }

}
