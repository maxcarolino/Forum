<?php
class AppException extends Exception
{

}
class RecordNotFoundException extends ValidationException
{

}
class ValidationException extends AppException
{

}
class NotFoundException extends AppException
{

}
class DuplicateEntryException extends AppException
{

}
class FileTypeException extends AppException
{
	
}