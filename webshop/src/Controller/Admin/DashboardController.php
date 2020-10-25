<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    private $userRepository;
    private $productRepository;
    public function __construct(UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }


    /**
     * @Route("/admin", name="admin")
     * @throws NonUniqueResultException
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'userCount' => $this->userRepository->countAllUsers() ,
            'productCount'=> $this->productRepository->countAllProducts(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Webshop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Manage your Store');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Product', 'fas fa-box', Product::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-truck-moving', Order::class);
        yield MenuItem::linktoRoute('Add Admin', 'fas fa-users', 'home');
        yield MenuItem::linktoRoute('Account Settings', 'fas fa-user-cog', 'user_settings');
        yield MenuItem::linktoRoute('Back To Store', 'fas fa-chevron-circle-left', 'home');

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserAvatar('true')
            ->setAvatarUrl('data:image/png;base64,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')
            ->setName($user->getUsername())
            ;
    }
}
