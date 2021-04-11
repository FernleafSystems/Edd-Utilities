<?php

namespace FernleafSystems\Integrations\Edd\Utilities;

/**
 * Class GetEddPaymentFromGatewayTxnId
 * @package FernleafSystems\Integrations\Edd\Utilities
 */
class GetEddPaymentFromGatewayTxnId {

	/**
	 * @param string $txnID
	 * @return \EDD_Payment|null
	 */
	public function retrieve( $txnID ) {
		$payment = null;

		$pID = edd_get_purchase_id_by_transaction_id( $txnID );
		if ( !empty( $pID ) ) { // must be the first purchase of a subscription.
			$payment = edd_get_payment( $pID );
		}
		else {
			$sub = ( new GetSubscriptionsFromGatewayTxnId() )->retrieve( $txnID );
			if ( !is_null( $sub ) ) {
				$payment = edd_get_payment( $sub->get_original_payment_id() );
			}
		}
		return $payment;
	}
}