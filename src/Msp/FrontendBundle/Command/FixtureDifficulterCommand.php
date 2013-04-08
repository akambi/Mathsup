<?php

namespace Msp\FrontendBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Msp\FrontendBundle\Entity\Difficulter;

class FixtureDifficulterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mspfrontend:fixture:difficulter');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    //  On récupère l'EntityManager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    //  liste des données à ajouter
        $difficultes = array('Très facile', 'Facile', 'Moyen', 'Difficile', 'Très difficile');
    //  On persiste les données
        foreach($difficultes as $i => $libelle)
        {
            $output->writeln('Creation de la difficulter : '.$libelle);
        // On crée la catégorie
            $liste_difficulter[$i] = new Difficulter();
            $liste_difficulter[$i]->setLibelle( $libelle );
            $liste_difficulter[$i]->setNombreEtoile( $i + 1 );
        // On la persiste
            $em->persist($liste_difficulter[$i]);
        }
        $output->writeln('Enregistrement des difficultés...');
    // On déclenche l'neregistrement
        $em->flush();
    // On retourne 0 pour dire que la commande s'est bien exécutée
        return 0;
    }
}
?>
