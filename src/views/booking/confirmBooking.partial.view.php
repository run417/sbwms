<?php
    $b = $booking;
?>
<div class="dt"><span class="ht">Booking ID:</span> <span class="bt" id="booking-id" data-booking-id="<?= $b->getBookingId(); ?>"><?= $b->getBookingId(); ?></span></div>
<div class="dt"><span class="ht">Service Type:</span> <span class="bt"><?= $b->getServiceType()->getName(); ?></span></div>
<div class="dt"><span class="ht">Date:</span> <span class="bt"><?= $b->getStartDateTime()->format('Y-m-d'); ?></span></div>
<div class="dt"><span class="ht">Start Time:</span> <span class="bt"><?= $b->getStartDateTime()->format('H:i:s'); ?></span></div>
<div class="dt"><span class="ht">Technician:</span> <span class="bt"><?= $b->getEmployee()->getFullName(); ?></span></div>
<div class="dt"><span class="ht">Duration:</span> <span class="bt"><?= $b->getServiceType()->getDuration()->format('Approx. %H hours and %i minutes'); ?></span></div>
<div class="dt"><span class="ht">Customer:</span> <span class="bt"><?= $b->getCustomer()->getFullName(); ?></span></div>
<div class="dt"><span class="ht">Telephone:</span> <span class="bt"><?= $b->getCustomer()->getTelephone(); ?></span></div>
<div class="dt"><span class="ht">Vehicle:</span> <span class="bt"><?= $b->getVehicle()->getVehicleDetails(); ?></span></div>