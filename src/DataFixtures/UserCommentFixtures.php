<?php

namespace App\DataFixtures;

use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\UserComment;

class UserCommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            'bob',
            'fred',
            'alice',
            'john',
            'emma',
        ];

        $shows = [
            'Ayiti',
            'Cible mouvante',
            'Ceci n\'est pas un chanteur belge',
            'Manneke… !',
        ];

        $comments = [
            'Je suis resté captivé du début à la fin de ce spectacle époustouflant. Les performances des acteurs étaient incroyables, et la mise en scène était à couper le souffle. Je recommande vivement cette expérience unique.',
            'Le spectacle était un véritable tourbillon d\'émotions. Les dialogues percutants et les scènes intenses ont créé une atmosphère électrisante. J\'ai été transporté dans un autre monde pendant toute la représentation.',
            'Ce spectacle m\'a fait réfléchir et remettre en question mes convictions. Les thèmes abordés étaient profonds et pertinents, et les artistes ont su les interpréter avec une sensibilité remarquable. Une expérience artistique qui restera gravée dans ma mémoire.',
            'La performance des acteurs était exceptionnelle. Les décors et les costumes étaient magnifiques, créant une atmosphère immersive. J\'ai été totalement absorbé par l\'histoire et les émotions transmises. Bravo à toute l\'équipe !',
            '',
        ];

        $slugify = new Slugify();

        foreach ($users as $userLogin) {
            $user = $this->getReference($userLogin);
        
            foreach ($shows as $showRecord) {
                $showSlug = $slugify->slugify($showRecord);
                $show = $this->getReference($showSlug);
        
                $comment = new UserComment();
                $comment->setUser($user);
                $comment->setShow($show);
        
                $randomComment = $comments[array_rand($comments)];
                $comment->setContenu($randomComment !== '' ? $randomComment : null);
        
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ShowFixtures::class,
        ];
    }
}
