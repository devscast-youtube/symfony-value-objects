<?php

declare(strict_types=1);

namespace App\UseCase\QueryHandler;

use App\Entity\ValueObject\Factory\AddressFactory;
use App\Exception\StudentNotFound;
use App\ReadModel\StudentProfile;
use App\StudentCacheKeys;
use App\UseCase\Query\GetStudentProfile;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class GetStudentProfileHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler('query.bus')]
final readonly class GetStudentProfileHandler
{
    use StudentQuery;

    public function __construct(
        private Connection $connection,
        private AddressFactory $addressFactory
    ) {
    }

    public function __invoke(GetStudentProfile $query): StudentProfile
    {
        $qb = $this->createBaseQuery()
            ->andWhere('s.id = :id')
            ->setParameter('id', $query->studentId)
            ->enableResultCache(new QueryCacheProfile(0, StudentCacheKeys::PROFILE->withId($query->studentId)))
        ;

        /** @var false|array $data */
        $data = $qb->executeQuery()->fetchAssociative();

        if ($data === false) {
            throw StudentNotFound::withId($query->studentId);
        }

        return $this->mapStudentProfile($data);
    }
}
