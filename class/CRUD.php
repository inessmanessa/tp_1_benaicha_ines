<?php
class Crud {
    
    public function getOrdinateurs() {
        global $pdo; 
        $PDOStatement = $pdo->query("SELECT * FROM ordinateur ORDER BY id ASC"); 
        $ordinateurs = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $ordinateurs; 
    }

    
    public function getOrdinateurById($id) {
        global $pdo; 
        $PDOStatement = $pdo->prepare("SELECT * FROM ordinateur WHERE id = :id"); 
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        $ordinateur = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $ordinateur;
    }

    
    public function putOrdinateur($ordinateur) {
        global $pdo;
        $PDOStatement = $pdo->prepare("INSERT INTO ordinateur (brand, price, generation) VALUES (:brand, :price, :generation)");
        $PDOStatement->bindParam(':brand', $ordinateur['brand'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':price', $ordinateur['price'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':generation', $ordinateur['generation'], PDO::PARAM_STR);
        $PDOStatement->execute();
        if ($PDOStatement->rowCount() <= 0) {
            return false;
        }
        return $pdo->lastInsertId();
    }

    
    public function updateOrdinateurById($id, $ordinateur) {
        global $pdo; 
        $PDOStatement = $pdo->prepare("UPDATE ordinateur SET brand = :brand, price = :price, generation = :generation WHERE id = :id");
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $PDOStatement->bindParam(':brand', $ordinateur['brand'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':price', $ordinateur['price'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':generation', $ordinateur['generation'], PDO::PARAM_STR);
        $PDOStatement->execute();
    }

    
    public function deleteOrdinateurById($id) {
        $ordinateur = $this->getOrdinateurById($id);
        global $pdo;
        if ($ordinateur) {
            $PDOStatement = $pdo->prepare("DELETE FROM ordinateur WHERE id = :id");
            $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
            $PDOStatement->execute();
            return "L'ordinateur avec l'ID " . $id . " a été supprimé.";
        } else {
            return "Ordinateur introuvable";
        }
    }
}
