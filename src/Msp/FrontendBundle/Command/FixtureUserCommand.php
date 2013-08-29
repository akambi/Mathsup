<?php

namespace Msp\FrontendBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Msp\UserBundle\Entity\User;

class FixtureUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mspfrontend:fixture:user');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    //  On récupère l'EntityManager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        
    //  On crée la catégorie
        $user = new User();
        $user->setUsername('admin');
        $user->setNom('admin');
        $user->setPrenom('admin');
        $user->setPrenom('admin');
        $user->setEnabled(true);
        $user->setEmail('admin@admin.com');
        $user->setPlainPassword('admin');
        $user->setRoles(array('ROLE_ADMIN'));
    //  On la persiste
        $em->persist($user);
        
    //  On déclenche l'neregistrement
        $em->flush();
        
        $output->writeln('Enregistrement de admin...');
    // On déclenche l'neregistrement
        $em->flush();
    // On retourne 0 pour dire que la commande s'est bien exécutée
        return 0;
    }
}
?>
