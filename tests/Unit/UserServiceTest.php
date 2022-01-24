<?php


namespace Unit;


use App\Models\User;
use App\Repository\Interfaces\IUserRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use LogicException;

class UserServiceTest extends \TestCase
{
    /**
     * @test
     */
    public function shouldGetAllUsers()
    {
        $expectedValues = [1, 2, 3];
        // Stub - retorno fake para a função
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('all')->willReturn($expectedValues);
        // Mock - garantindo que a função all do repository é chamado uma vez ao buscar todos os usuários
        $userRepository->expects($this->once())->method('all');

        $userService = new UserService($userRepository);
        $values = $userService->all();

        $this->assertEquals($expectedValues, $values);
        $this->assertIsArray($values);
    }

    /**
     * @test
     */
    public function shouldFindAndReturnAnUser()
    {
        $userRepository = $this->createMock(UserRepository::class);
        // Stub - força o retorno
        $userRepository->method('find')->willReturn('joao');
        // Mock - Asserção pelo comportamento, garantindo que o metodo find deve ser chamado uma vez
        $userRepository->expects($this->once())->method('find');


        $userService = new UserService($userRepository);
        $result = $userService->find(1);

        $this->assertEquals('joao', $result);
    }

    /**
     * @test
     */
    public function shouldNotFindAndReturnException()
    {

        $userRepository = $this->createStub(UserRepository::class);
        $userRepository->method('find')->willReturn(null);
        $userRepository->expects($this->once())->method('find');

        $userService = new UserService($userRepository);

        $this->expectException(LogicException::class);
        $userService->find(10);
    }

}
