<?php

namespace OneMoreAngle\Marshaller\Test\Fixtures;

use OneMoreAngle\Marshaller\Attribute\Aliases;
use OneMoreAngle\Marshaller\Attribute\Name;
use OneMoreAngle\Marshaller\Attribute\Omit;
use OneMoreAngle\Marshaller\Attribute\OmitEmpty;

class ReadmeCustomClass {
    /**
     * @Name("custom_name")
     * @Aliases({"alias1", "alias2"})
     * @OmitEmpty()
     */
    #[Name('custom_name')]
    #[Aliases(['alias1', 'alias2'])]
    #[OmitEmpty]
    public string $property;

    /**
     * @Omit()
     */
    #[Omit]
    public string $property2;
}