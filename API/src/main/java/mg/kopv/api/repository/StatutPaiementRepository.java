package mg.kopv.api.repository;

import mg.kopv.api.entity.StatutPaiement;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface StatutPaiementRepository extends JpaRepository<StatutPaiement, Integer> {

    Optional<StatutPaiement> findByLibelle(String libelle);
}
