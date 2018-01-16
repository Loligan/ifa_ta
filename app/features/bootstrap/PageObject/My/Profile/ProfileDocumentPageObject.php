<?php

namespace PageObject\My\Profile;


use PageObject\PageObject;

class ProfileDocumentPageObject extends PageObject
{
    const TYPE_POI_SELECT = './/select[@id="proof_of_identity_subtype"]';
    const TYPE_POI_OPTION = './/select[@id="proof_of_identity_subtype"]/option[text()="VALUE"]';
    const POI_FILE_INPUT = './/input[@id="proof_of_identity_file"]';

    const TYPE_POR_SELECT = './/select[@id="proof_of_address_subtype"]';
    const TYPE_POR_OPTION = './/select[@id="proof_of_address_subtype"]/option[text()="VALUE"]';
    const POR_FILE_INPUT = './/input[@id="proof_of_address_file"]';

    const TYPE_POP_SELECT = './/select[@id="proof_of_address_subtype"]';
    const TYPE_POP_OPTION = './/select[@id="proof_of_address_subtype"]/option[text()="VALUE"]';
    const POP_FILE_INPUT = './/input[@id="proof_of_payment_file"]';


}