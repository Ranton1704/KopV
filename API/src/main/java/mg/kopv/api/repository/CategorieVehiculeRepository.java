package mg.kopv.api.repository;

import mg.kopv.api.entity.CategorieVehicule;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface CategorieVehiculeRepository extends JpaRepository<CategorieVehicule, Integer> {
}
