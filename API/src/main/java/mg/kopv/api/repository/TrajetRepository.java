package mg.kopv.repository;

import mg.kopv.api.entity.Trajet;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface TrajetRepository extends JpaRepository<Trajet, Integer> {

    // Utilisé par /api/trajet/list (libelle = gareDepart.nom - gareArrivee.nom)
}
