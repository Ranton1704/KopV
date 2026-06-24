package mg.kopv.api.entity;

import jakarta.persistence.*;
import java.math.BigDecimal;
import java.time.LocalDateTime;

@Entity
@Table(name = "voyages")
public class Voyage {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @ManyToOne
    @JoinColumn(name = "id_trajet", nullable = false)
    private Trajet trajet;

    @ManyToOne
    @JoinColumn(name = "id_vehicule", nullable = false)
    private Vehicule vehicule;

    @Column(name = "id_chauffeur", nullable = false)
    private Integer idChauffeur;

    @Column(name = "date_heure_depart", nullable = false)
    private LocalDateTime dateHeureDepart;

    @Column(name = "duree_estimee_minutes", nullable = false)
    private Integer dureeEstimeeMinutes;

    @Column(name = "tarif", nullable = false, precision = 10, scale = 2)
    private BigDecimal tarif;

    public Voyage() {}

    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }

    public Trajet getTrajet() { return trajet; }
    public void setTrajet(Trajet trajet) { this.trajet = trajet; }

    public Vehicule getVehicule() { return vehicule; }
    public void setVehicule(Vehicule vehicule) { this.vehicule = vehicule; }

    public Integer getIdChauffeur() { return idChauffeur; }
    public void setIdChauffeur(Integer idChauffeur) { this.idChauffeur = idChauffeur; }

    public LocalDateTime getDateHeureDepart() { return dateHeureDepart; }
    public void setDateHeureDepart(LocalDateTime dateHeureDepart) { this.dateHeureDepart = dateHeureDepart; }

    public Integer getDureeEstimeeMinutes() { return dureeEstimeeMinutes; }
    public void setDureeEstimeeMinutes(Integer dureeEstimeeMinutes) { this.dureeEstimeeMinutes = dureeEstimeeMinutes; }

    public BigDecimal getTarif() { return tarif; }
    public void setTarif(BigDecimal tarif) { this.tarif = tarif; }
}
