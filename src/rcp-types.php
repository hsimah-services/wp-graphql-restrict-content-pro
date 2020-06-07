<?php

final class WPGraphQL_RCP_Types {
  public static function register_enum() {
    register_graphql_enum_type('RCPEmailStatus', [
      'description'  => __('The user email verification status', 'wpgraphql-restrict-content-pro'),
      'values'       => [
        'VERIFIED' => [
          'value' => 'verified',
        ],
        'UNVERIFIED' => [
          'value' => 'unverified',
        ],
      ],
      'defaultValue' => 'UNVERIFIED',
    ]);

    register_graphql_enum_type('RCPMembershipStatus', [
      'description'  => __('The user membership status', 'wpgraphql-restrict-content-pro'),
      'values'       => [
        'ACTIVE' => [
          'value' => 'active',
        ],
        'EXPIRED' => [
          'value' => 'expired',
        ],
        'CANCELLED' => [
          'value' => 'cancelled',
        ],
        'PENDING' => [
          'value' => 'pending',
        ],
        'FREE' => [
          'value' => 'free',
        ],
      ],
      'defaultValue' => 'free',
    ]);
  }

  public static function register_membership() {
    $fields = [
      'id' => [
        'type' => 'String',
        'description' => __('Membership ID.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_id();
        }
      ],
      'customer' => [
        'type' => 'RCPCustomer',
        'description' => __('Corresponding customer object.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_customer();
        }
      ],
      'currency' => [
        'type' => 'String',
        'description' => __('Currency used for membership payments.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_currency();
        }
      ],
      'initialAmount' => [
        'type' => 'Float',
        'description' => __('Initial payment amount.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_initialAmount();
        }
      ],
      'recurringAmount' => [
        'type' => 'Float',
        'description' => __('Recurring amount.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_recurring_amount();
        }
      ],
      'createdDate' => [
        'type' => 'String',
        'description' => __('Date the membership was created.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_created_date();
        }
      ],
      'activatedDate' => [
        'type' => 'String',
        'description' => __('Date the membership was activated.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_activated_date();
        }
      ],
      'trialEndDate' => [
        'type' => 'String',
        'description' => __('Last day of the trial. If no trial then this will be blank.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_trial_end_date();
        }
      ],
      'renewedDate' => [
        'type' => 'String',
        'description' => __('Date the membership was last renewed.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_renewed_date();
        }
      ],
      'cancellationDate' => [
        'type' => 'String',
        'description' => __('Date the membership was cancelled. If it hasn\'t been cancelled this will be blank.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_cancellation_date();
        }
      ],
      'expirationDate' => [
        'type' => 'String',
        'description' => __('Date the membership expires or is next due for a renewal. If this is a lifetime membership then this will be `null`.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_expiration_date();
        }
      ],
      'paymentPlanCompletedDate' => [
        'type' => 'String',
        'description' => __('Date the payment plan was completed, or `null` if it hasn\'t been.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_payment_plan_completed_date();
        }
      ],
      'timesBilled' => [
        'type' => 'Int',
        'description' => __('Number of times this membership has been billed for, including the first payment.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_times_billed();
        }
      ],
      'maximumRenewals' => [
        'type' => 'Int',
        'description' => __('Maximum number of times to renew this membership. Default is `0` for unlimited.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_maximum_renewals();
        }
      ],
      'status' => [
        'type' => 'RCPMembershipStatus',
        'description' => __('Status of this membership: `active`, `cancelled`, `expired`, or `pending`.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_status();
        }
      ],
      'autoRenew' => [
        'type' => 'Boolean',
        'description' => __('Whether or not this membership automatically renews.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_auto_renew();
        }
      ],
      'gatewayCustomerId' => [
        'type' => 'String',
        'description' => __('Customer ID number with the gateway. This is a user profile ID - not a subscription ID. For example, if using Stripe then this ID begins with "cus_". Not all gateways have this.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_gateway_customer_id();
        }
      ],
      'gatewaySubscriptionId' => [
        'type' => 'String',
        'description' => __('ID of the subscription with the payment gateway. If using Stripe then this ID begins with "sub_".', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_gateway_subscription_id();
        }
      ],
      'gateway' => [
        'type' => 'String',
        'description' => __('Payment gateway used for billing.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_gateway();
        }
      ],
      'signupMethod' => [
        'type' => 'String',
        'description' => __('Method used to create this membership. Options include: `live` (via the registration form), `manual` (manually) added by a site admin), and `imported`.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_signup_method();
        }
      ],
      'subscriptionKey' => [
        'type' => 'String',
        'description' => __('Subscription key.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_subscription_key();
        }
      ],
      'notes' => [
        'type' => 'String',
        'description' => __('Membership notes.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_notes();
        }
      ],
      'upgradedFrom' => [
        'type' => 'Int',
        'description' => __('ID of the membership this one upgraded from.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_upgraded_from();
        }
      ],
      'dateModified' => [
        'type' => 'String',
        'description' => __('Date this membership was last modified.', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_date_modified();
        }
      ],
      'disabled' => [
        'type' => 'Boolean',
        'description' => __('Whether this membership is disabled (`0` = not disabled; `1` = disabled).', 'wpgraphql-restrict-content-pro'),
        'resolve' => function ($node) {
          return $node->get_disabled();
        }
      ],
    ];

  }
}