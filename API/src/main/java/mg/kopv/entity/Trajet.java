package mg.kopv.api.entity;

import jakarta.persistence.*;
import java.math.BigDecimal;

@Entity
@Table(name = "trajets")
public class Trajet {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @ManyToOne
    @JoinColumn(name = "id_gare_depart", nullable = false)
    private Gare gareDepart;

    @ManyToOne
    @JoinColumn(name = "id_gare_arrivee", nullable = false)
    private Gare gareArrivee;

    @Column(name = "distance_km", nullable = false, precision = 10, scale = 2)
    private BigDecimal distanceKm;

    public Trajet() {}

    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }

    public Gare getGareDepart() { return gareDepart; }
    public void setGareDepart(Gare gareDepart) { this.gareDepart = gareDepart; }

    public Gare getGareArrivee() { return gareArrivee; }
    public void setGareArrivee(Gare gareArrivee) { this.gareArrivee = gareArrivee; }

    public BigDecimal getDistanceKm() { return distanceKm; }
    public void setDistanceKm(BigDecimal distanceKm) { this.distanceKm = distanceKm; }
}
