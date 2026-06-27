package mg.kopv.repository;

import mg.kopv.api.entity.Place;
import mg.kopv.api.entity.Vehicule;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface PlaceRepository extends JpaRepository<Place, Integer> {

    // Utilisé par /api/vehicule/{id}/place/list
    List<Place> findByVehicule(Vehicule vehicule);

    long countByVehicule(Vehicule vehicule);
}
