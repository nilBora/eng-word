<?php
class NotFoundException extends Exception
{
}

class SystemException extends Exception
{
}

class SocketException extends Exception
{
    const CONNECTION_ERROR = 6001;
}

class DisplayException extends Exception
{
}

class PermissionException extends Exception
{
}
