<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Pais;

class PaisControllerWebTest extends WebTestCase
{
    public function testIndexPageLoadsSuccessfully(): void
    {
        // Creamos el cliente HTTP simulado
        $client = static::createClient();

        // Obtenemos el EntityManager de Doctrine
        $em = $client->getContainer()->get('doctrine')->getManager();

        // Creamos un país de prueba
        $pais = new Pais();
        $pais->setNombre('Argentina');
        $em->persist($pais);
        $em->flush();

        // Hacemos la petición GET a la ruta /pais
        $crawler = $client->request('GET', '/pais');

        // Verificamos que la respuesta HTTP sea 200
        $this->assertResponseIsSuccessful();

        // Verificamos que haya un <h1> con el título esperado
        $this->assertSelectorTextContains('h1', 'Pais');

        // Verificamos que haya una tabla en la página
        $this->assertSelectorExists('table');

        // Verificamos que el país de prueba aparezca en la tabla
        $this->assertSelectorTextContains('table', 'Argentina');

        // Limpiamos el país creado para no afectar otros tests
        $em->remove($pais);
        $em->flush();
    }
}
