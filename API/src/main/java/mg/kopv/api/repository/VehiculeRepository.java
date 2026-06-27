package mg.kopv.repository;

import mg.kopv.api.entity.Vehicule;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface VehiculeRepository extends JpaRepository<Vehicule, Integer> {

    boolean existsByImmatriculation(String immatriculation);
}
