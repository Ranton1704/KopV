package mg.kopv.repository;

import mg.kopv.api.entity.Client;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface ClientRepository extends JpaRepository<Client, Integer> {

    Optional<Client> findByTelephone(String telephone);

    // Utilisé par /api/client/list?recherche=
    Page<Client> findByNomContainingIgnoreCaseOrTelephoneContaining(String nom, String telephone, Pageable pageable);
}
