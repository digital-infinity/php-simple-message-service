<?php

declare(strict_types= 1);

namespace Core\Exceptions;
use Exception;
use Psr\Container\NotFoundExceptionInterface;

class InstanceNotFoundException extends Exception implements NotFoundExceptionInterface
{

}