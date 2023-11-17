<?php

namespace App\Actions\Tools;

use Illuminate\Support\Facades\Redis;

enum Direction: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}

class RedisHash
{
    private \Illuminate\Redis\Connections\Connection $redis;

    public function __construct(string $name = null)
    {
        $this->redis = Redis::connection($name);
    }

    /**
     * @description Define um array associativo a um hash
     * @param string $key
     * @param array $data
     * @return bool
     */
    public function setArray(string $key, array $data): bool
    {
        return $this->redis->command('HMSET', [$key, $data]);

    }

    /**
     * @description Retorna um array associativo de um hash
     * @param string $key
     * @return array
     */
    public function getArray(string $key): array
    {
        return $this->redis->command('HGETALL', [$key]);
    }

    /**
     * @description Define um valor a um campo de um hash
     * @param string $key
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function set(string $key, string $field, string $value): bool
    {
        return $this->redis->command('HSET', [$key, $field, $value]);
    }

    /**
     * @description Retorna um valor de um campo de um hash
     * @param string $key
     * @param string $field
     * @return string
     */
    public function get(string $key, string $field): string
    {
        return $this->redis->command('HGET', [$key, $field]);
    }

    /**
     * @description Deleta um campo de um hash
     * @param string $key
     * @param string $field
     * @return bool
     */
    public function delete(string $key, string $field): bool
    {
        return $this->redis->command('HDEL', [$key, $field]);
    }


    /**
     * @description Define uma lista
     * @param string $key
     * @param array $data
     * @param $direction
     * @return bool
     */
    public function setList(string $key, array $data, $direction = Direction::DESC): bool
    {
        $command = ($direction === "ASC") ? 'LPUSH' : 'RPUSH';
        return $this->redis->command($command, [$key, $data]);
    }

    /**
     * @description Retorna uma lista
     * @param string $key
     * @param int $start
     * @param int $stop
     * @return array
     */
    public function getList(string $key, int $start = 0, int $stop = -1): array
    {
        return $this->redis->command('LRANGE', [$key, $start, $stop]);
    }

    /**
     * @description Retorna um elemento da lista
     * @param string $key
     * @param int $index
     * @return string
     */
    public function getListIndex(string $key, int $index): string
    {
        return $this->redis->command('LINDEX', [$key, $index]);
    }


    /**
     * @description Deleta a lista
     * @param string $key
     * @return bool
     */
    public function deleteList(string $key): bool
    {
        return $this->redis->command('DEL', [$key]);
    }

    /**
     * @description Deleta um elemento da lista
     * @param string $key
     * @param string $element
     * @return bool
     */
    public function deleteListElement(string $key, string $element): bool
    {
        return $this->redis->command('LREM', [$key, 0, $element]);
    }


    /**
     * @description Define um conjunto
     * @param string $key
     * @param string $member
     * @return bool
     */
    public function setSet(string $key, string $member): bool
    {
        return $this->redis->command('SADD', [$key, $member]);
    }


    /**
     * @description Retorna um conjunto
     * @param string $key
     * @return array
     */
    public function getSet(string $key): array
    {
        return $this->redis->command('SMEMBERS', [$key]);
    }


    /**
     * @description Retorna um elemento do conjunto
     * @param string $key
     * @param string $member
     * @return bool
     */
    public function getSetMember(string $key, string $member): bool
    {
        return $this->redis->command('SISMEMBER', [$key, $member]);
    }


    /**
     * @description Deleta um elemento do conjunto
     * @param string $key
     * @param string $member
     * @return bool
     */
    public function deleteSetMember(string $key, string $member): bool
    {
        return $this->redis->command('SREM', [$key, $member]);
    }

    /**
     * @description Deleta o conjunto
     * @param string $key
     * @return bool
     */
    public function deleteSet(string $key): bool
    {
        return $this->redis->command('DEL', [$key]);
    }

    /**
     * @description Define um conjunto ordenado
     * @param string $key
     * @param string $member
     * @param int $score
     * @return bool
     */
    public function setSortedSet(string $key, string $member, int $score): bool
    {
        return $this->redis->command('ZADD', [$key, $score, $member]);
    }

    /**
     * @description Retorna um conjunto ordenado
     * @param string $key
     * @param int $start
     * @param int $stop
     * @param $direction
     * @return array
     */
    public function getSortedSet(string $key, int $start = 0, int $stop = -1, $direction = Direction::DESC): array
    {
        $command = ($direction === "ASC") ? 'ZRANGE' : 'ZREVRANGE';
        return $this->redis->command($command, [$key, $start, $stop]);
    }

    /**
     * @description Retorna um elemento do conjunto ordenado
     * @param string $key
     * @param string $member
     * @return int
     */
    public function getSortedSetScore(string $key, string $member): int
    {
        return $this->redis->command('ZSCORE', [$key, $member]);
    }

    /**
     * @description Deleta um elemento do conjunto ordenado
     * @param string $key
     * @param string $member
     * @return bool
     */
    public function deleteSortedSetMember(string $key, string $member): bool
    {
        return $this->redis->command('ZREM', [$key, $member]);
    }

    /**
     * @description Deleta o conjunto ordenado
     * @param string $key
     * @return bool
     */
    public function deleteSortedSet(string $key): bool
    {
        return $this->redis->command('DEL', [$key]);
    }

    // bit

    /**
     * @description Define um bit
     * @param string $key
     * @param int $offset
     * @param int $value
     * @return bool
     */
    public function setBit(string $key, int $offset, int $value): bool
    {
        return $this->redis->command('SETBIT', [$key, $offset, $value]);
    }

    /**
     * @description Retorna um bit
     * @param string $key
     * @param int $offset
     * @return int
     */
    public function getBit(string $key, int $offset): int
    {
        return $this->redis->command('GETBIT', [$key, $offset]);
    }

    /**
     * @description Retorna a quantidade de bits
     * @param string $key
     * @return int
     */
    public function getBitCount(string $key): int
    {
        return $this->redis->command('BITCOUNT', [$key]);
    }

    /**
     * @description Retorna a quantidade de bits com valor 1
     * @param string $operation
     * @param string $destKey
     * @param string $key1
     * @param string $key2
     * @return int
     */
    public function getBitOp(string $operation, string $destKey, string $key1, string $key2): int
    {
        return $this->redis->command('BITOP', [$operation, $destKey, $key1, $key2]);
    }

    /**
     * @description Deleta o bit
     * @param string $key
     * @return bool
     */
    public function deleteBit(string $key): bool
    {
        return $this->redis->command('DEL', [$key]);
    }

    // geo

    /**
     * @description Define um geo
     * @param string $key
     * @param float $longitude
     * @param float $latitude
     * @param string $member
     * @return bool
     */
    public function setGeo(string $key, float $longitude, float $latitude, string $member): bool
    {
        return $this->redis->command('GEOADD', [$key, $longitude, $latitude, $member]);
    }

    /**
     * @description Retorna um geo
     * @param string $key
     * @param string $member
     * @return array
     */
    public function getGeo(string $key, string $member): array
    {
        return $this->redis->command('GEOPOS', [$key, $member]);
    }

    /**
     * @description Retorna a distância entre dois membros
     * @param string $key
     * @param string $member1
     * @param string $member2
     * @param string $unit
     * @return float
     */
    public function getGeoDistance(string $key, string $member1, string $member2, string $unit = 'm'): float
    {
        return $this->redis->command('GEODIST', [$key, $member1, $member2, $unit]);
    }

    /**
     * @description Retorna os membros num raio
     * @param string $key
     * @param float $longitude
     * @param float $latitude
     * @param float $radius
     * @param string $unit
     * @param int $count
     * @param $direction
     * @return array
     */
    public function getGeoRadius(string $key, float $longitude, float $latitude, float $radius, string $unit = 'm', int $count = 0, $direction = Direction::ASC): array
    {
        $command = ($direction === "ASC") ? 'GEORADIUS' : 'GEORADIUSBYMEMBER';
        return $this->redis->command($command, [$key, $longitude, $latitude, $radius, $unit, 'COUNT', $count]);
    }

    /**
     * @description Deleta o geo
     * @param string $key
     * @return bool
     */
    public function deleteGeo(string $key): bool
    {
        return $this->redis->command('DEL', [$key]);
    }

    /** HyperLog */

    /**
     * @description Define um HyperLogLog
     * @param string $key
     * @param string $element
     * @return bool
     */
    public function setHyperLogLog(string $key, string $element): bool
    {
        return $this->redis->command('PFADD', [$key, $element]);
    }

    /**
     * @description Retorna um HyperLogLog
     * @param string $key
     * @return int
     */
    public function getHyperLogLog(string $key): int
    {
        return $this->redis->command('PFCOUNT', [$key]);
    }

    /**
     * @description Deleta o HyperLogLog
     * @param string $key
     * @return bool
     */
    public function deleteHyperLogLog(string $key): bool
    {
        return $this->redis->command('DEL', [$key]);
    }


    /**
     * @description Retorna o tempo de execução do comando PING em milissegundos
     * @return float
     */
    public function getPing(): float
    {
        $atual = microtime(true);
        $this->redis->command('PING');
        $final = microtime(true);
        return ($final - $atual) * 1000;
    }


    /**
     * @description Retorna a chave conforme o padrão
     * @param string $pattern
     * @return array
     */
    public function getKeys(string $pattern): array
    {
        return $this->redis->command('KEYS', [$pattern]);
    }


    /**
     * @description Verifica se a chave existe
     * @param string $key
     * @return bool
     */
    public function getExists(string $key): bool
    {
        return $this->redis->command('EXISTS', [$key]);
    }


    /**
     * @description Define o tempo de vida da chave em segundos
     * @param string $key
     * @param int $seconds
     * @return bool
     */
    public function setExpire(string $key, int $seconds): bool
    {
        return $this->redis->command('EXPIRE', [$key, $seconds]);
    }


    /**
     * @description Define o tempo de vida da chave em milissegundos
     * @param string $key
     * @param int $milliseconds
     * @return bool
     */
    public function setPExpire(string $key, int $milliseconds): bool
    {
        return $this->redis->command('PEXPIRE', [$key, $milliseconds]);
    }


    /**
     * @description Define o tempo de vida da chave em uma data-hora
     * @param string $key
     * @param string $timestamp
     * @return bool
     */
    public function setExpireAt(string $key, string $timestamp): bool
    {
        $timestampOk = strtotime($timestamp);
        return $this->redis->command('EXPIREAT', [$key, $timestampOk]);
    }


    /**
     * @description Retorna o uso de memória da chave
     * @param string $key
     * @return int
     */
    public function getMemory(string $key): int
    {
        return $this->redis->command('MEMORY', ['USAGE', $key]);
    }


    /**
     * @description Retorna o uso de memória do servidor
     * @return array
     */
    public function getMemoryStats(): array
    {
        return $this->redis->command('MEMORY', ['STATS']);
    }


}
