<?php

namespace Msp\FrontendBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Msp\FrontendBundle\Entity\Niveau;

class FixtureNiveauCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mspfrontend:fixture:niveau');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    //  On récupère l'EntityManager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    //  liste des données à ajouter
        $niveau = array('Primaire', 'Collège', 'Lycée', 'Université');
    //  On persiste les données
        foreach($niveau as $i => $libelle)
        {
            $output->writeln('Creation du niveau : '.$libelle);
        // On crée la catégorie
            $liste_niveau[$i] = new Niveau();
            $liste_niveau[$i]->setLibelle($libelle);
        // On la persiste
            $em->persist($liste_niveau[$i]);
        }
        $output->writeln('Enregistrement des Niveaux...');
    // On déclenche l'neregistrement
        $em->flush();
    // On retourne 0 pour dire que la commande s'est bien exécutée
        return 0;
    }
}
?>
