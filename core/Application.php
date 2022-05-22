<?php

namespace app\core;

class Application
{
    public static Application $app;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Controller $controller;
    public Database $db;
    public Session $session;
    public ?DbValidationModel $user;
    public mixed $class;

    public function __construct(string $rootPath, array $config)
    {
        $this->initApp($rootPath, $config);
        $this->findSessionUser();
    }

    private function initApp(string $rootPath, array $config): void
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->session = new Session();
        $this->controller = new Controller();
        $this->router = new Router($this->request);
        $this->db = new Database();
        $this->class = $config["class"];
    }

    private function findSessionUser(): void
    {
        $primaryValue = $this->session->get("user");
        if ($primaryValue) {
            $primaryKey = "id";
            $this->user = $this->class::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run(): string
    {
        return $this->router->resolve();
    }

    public function login($user): bool
    {
        $this->user = $user;
        $this->session->set("user", $user->id);

        return true;
    }

    public function logout(): void
    {
        $this->session->remove("user");
        $this->user = null;
    }

    public function isGuest(): bool
    {
        return !$this->user;
    }
}
