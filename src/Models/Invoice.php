<?php

namespace LasseRafn\Dinero\Models;

use LasseRafn\Dinero\Builders\PaymentBuilder;
use LasseRafn\Dinero\Requests\PaymentRequestBuilder;
use LasseRafn\Dinero\Utils\Model;

class Invoice extends Model
{
	protected $entity     = 'invoices';
	protected $primaryKey = 'Guid';

	public $PaymentDate;
	public $PaymentStatus;
	public $PaymentConditionNumberOfDays;
	public $PaymentConditionType;
	public $Status;
	public $ContactGuid;
	public $Guid;
	public $TimeStamp;
	public $CreatedAt;
	public $UpdatedAt;
	public $DeletedAt;
	public $Number;
	public $ContactName;
	public $TotalExclVat;
	public $TotalVatableAmount;
	public $TotalInclVat;
	public $TotalNonVatableAmount;
	public $TotalVat;

	/** @var array */
	public $TotalLines;

	public $Currency;
	public $Language;
	public $ExternalReference;
	public $Description;
	public $Comment;
	public $Date;

	public $Type;
	public $TotalInclVatInDkk;
	public $TotalExclVatInDkk;
	public $MailOutStatus;

	/** @var array */
	public $ProductLines;

	public $Address;

    /**
     * @return PaymentRequestBuilder
     */
	public function payments() {
		return new PaymentRequestBuilder( new PaymentBuilder( $this->request, "invoices/{$this->Guid}/payments" ) );
	}

    /**
     * @param $orgId
     * @return mixed
     */
	public function book($orgId) {

	    return $this->request->curl->post('https://api.dinero.dk/v1/' . $orgId . '/invoices/' . $this->{$this->primaryKey} . '/book', [

	        'json' => [

	            'Timestamp' => $this->{'TimeStamp'},
            ]
        ]);
    }

    /**
     * Send invoice to customer by email @todo Add possible email parameters from https://api.dinero.dk/openapi/index.html#tag/Invoices/paths/~1v1~1{organizationId}~1invoices~1{guid}~1email/post
     *
     * @param $orgId
     * @return mixed
     */
    public function send($orgId)
    {
        return $this->request->curl->post('https://api.dinero.dk/v1/' . $orgId . '/invoices/' . $this->{$this->primaryKey} . '/email');
    }
}
