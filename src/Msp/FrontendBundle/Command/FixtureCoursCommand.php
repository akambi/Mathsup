<?php

namespace Msp\FrontendBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Msp\FrontendBundle\Entity\Cours;

class FixtureCoursCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mspfrontend:fixture:cours');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    //  On récupère l'EntityManager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    //  liste des données à ajouter
        $cours = array('Cours à domicile', 'Cours à distance', 'Classes virtuelles');
    //  On persiste les données
        foreach($cours as $i => $libelle)
        {
            $output->writeln('Creation du cours : '.$libelle);
        // On crée la catégorie
            $liste_cours[$i] = new Cours();
            $liste_cours[$i]->setLibelle($libelle);
        // On la persiste
            $em->persist($liste_cours[$i]);
        }
        $output->writeln('Enregistrement des cours...');
    // On déclenche l'neregistrement
        $em->flush();
    // On retourne 0 pour dire que la commande s'est bien exécutée
        return 0;
    }
}
?>
