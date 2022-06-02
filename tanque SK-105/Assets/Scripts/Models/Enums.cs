public enum ImpactBody {
    Oruga = 0,
    Canon = 1,
    Batea = 2,
    Cabina = 3,
}

public enum TypeBullet {
    CargaHueca = 0,
    AltoExplosivo = 1,
    Practica = 2,
}

public enum Dificulty {
    Facil,
    Normal,
    Dificil,
}

public class States {
    public const string Low = "1";
    public const string Start = "2";
    public const string Pause = "3";
    public const string ConfirmPause = "4";
    public const string Unpause = "5";
}