<?php

namespace Msp\FrontendBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Msp\FrontendBundle\Entity\Classe;

class FixtureClasseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mspfrontend:fixture:classe');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    //  On récupère l'EntityManager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $liste_niveau = $em->getRepository('MspFrontendBundle:Niveau')->findAll();
    //  liste des données à ajouter
        $classe_college = array('6ème', '5ème', '4ème', '3ème');
        $classe_lycee = array('2nde', '1ère', 'Tle');
        $classe_universite = array('Licence', 'Prepa');
    //  On persiste les données
        foreach($liste_niveau as $y => $niveau)
        {
            if( $niveau->getId() == 2):
                foreach($classe_college as $i => $libelle)
                {
                    $output->writeln('Creation de la classe : '.$libelle);
                // On crée la catégorie
                    $liste_classe[$y][$i] = new Classe();
                    $liste_classe[$y][$i]->setLibelle( $libelle );
                    $liste_classe[$y][$i]->setNiveau( $niveau );
                // On la persiste
                    $em->persist($liste_classe[$y][$i]);
                }
            elseif( $niveau->getId() == 3):
                foreach($classe_lycee as $i => $libelle)
                {
                    $output->writeln('Creation de la classe : '.$libelle);
                // On crée la catégorie
                    $liste_classe[$y][$i] = new Classe();
                    $liste_classe[$y][$i]->setLibelle( $libelle );
                    $liste_classe[$y][$i]->setNiveau( $niveau );
                // On la persiste
                    $em->persist($liste_classe[$y][$i]);
                }
            elseif( $niveau->getId() == 4):
                foreach($classe_universite as $i => $libelle)
                {
                    $output->writeln('Creation de la classe : '.$libelle);
                // On crée la catégorie
                    $liste_classe[$y][$i] = new Classe();
                    $liste_classe[$y][$i]->setLibelle( $libelle );
                    $liste_classe[$y][$i]->setNiveau( $niveau );
                // On la persiste
                    $em->persist($liste_classe[$y][$i]);
                }
            endif;
        }
        
        $output->writeln('Enregistrement des classes...');
    // On déclenche l'neregistrement
        $em->flush();
    // On retourne 0 pour dire que la commande s'est bien exécutée
        return 0;
    }
}
?>
