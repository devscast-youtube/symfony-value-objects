<?php

declare(strict_types=1);

namespace App\UseCase\QueryHandler;

use App\Entity\ValueObject\Factory\AddressFactory;
use App\ReadModel\StudentList;
use App\StudentCacheKeys;
use App\UseCase\Query\GetStudentList;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class GetStudentListHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler('query.bus')]
final readonly class GetStudentListHandler
{
    use StudentQuery;

    public function __construct(
        private Connection $connection,
        private AddressFactory $addressFactory
    ) {
    }

    public function __invoke(GetStudentList $query): StudentList
    {
        $qb = $this->createBaseQuery()
            ->enableResultCache(new QueryCacheProfile(0, StudentCacheKeys::LIST->value))
        ;

        /** @var false|array $data */
        $data = $qb->executeQuery()->fetchAllAssociative();

        return $this->mapStudentList($data);
    }

    private function mapStudentList(array $data): StudentList
    {
        return new StudentList(array_map(fn ($item) => $this->mapStudentProfile($item), $data));
    }
}
