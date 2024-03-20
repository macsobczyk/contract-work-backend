FROM php:8.2-fpm

# Install fpm extension
RUN apt-get update && apt-get install -y \
        freetds-bin \
        freetds-dev \
        freetds-common \
        libsybdb5 \
        libzip-dev \
        libbz2-dev \
        libc-client-dev \
        libfreetype6-dev \
        libicu-dev \
        libonig-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libkrb5-dev \
        libmcrypt-dev \
        libpcre3-dev \
        libgmp3-dev \
        libpng-dev \
        libxml2-dev \
        libxml2-utils \
        libcairo2 \
        libfontconfig1 \
        libfreetype6 \
        libgif7 \
        libgomp1 \
        libpixman-1-0 \
        liblcms2-dev \
        libxml2 \
        libldap2-dev \
        libxslt-dev \
        libssh-dev \
        libpq-dev \
        libsodium-dev \
        librabbitmq-dev \
        nano \
        wget \
        make \
        git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && phpModules=" \
            apcu \
            amqp \
            bcmath \
            bz2 \
            calendar \
            exif \
            gd \
            gettext \
            gmp \
            imap \
            intl \
            ldap \
            msgpack \
            pcntl \
            pdo \
            pdo_dblib \
            pdo_pgsql \
            pgsql \
            redis \
            shmop \
            soap \
            sodium \
            sockets \
            sysvmsg \
            sysvsem \
            sysvshm \
            xdebug \
            xsl \
            zip \
        " \
    && NPROC=$(getconf _NPROCESSORS_ONLN) \
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
    && ln -s /usr/lib/x86_64-linux-gnu/libldap_r.so /usr/lib/libldap.so \
    && ln -s /usr/lib/x86_64-linux-gnu/libldap_r.a /usr/lib/libldap_r.a \
    && ln -s /usr/lib/x86_64-linux-gnu/libsybdb.a /usr/lib/libsybdb.a \
    && ln -s /usr/lib/x86_64-linux-gnu/libsybdb.so /usr/lib/libsybdb.so \
    && mkdir -p /usr/src/php/ext/amqp \
    && mkdir -p /usr/src/php/ext/apcu  \
    && mkdir -p /usr/src/php/ext/redis  \
    && mkdir -p /usr/src/php/ext/xdebug  \
    && mkdir -p /usr/src/php/ext/msgpack  \
    && curl -fsSL https://pecl.php.net/get/amqp | tar xvz -C "/usr/src/php/ext/amqp" --strip 1 \
    && curl -fsSL https://pecl.php.net/get/apcu | tar xvz -C "/usr/src/php/ext/apcu" --strip 1 \
    && curl -fsSL https://pecl.php.net/get/redis | tar xvz -C "/usr/src/php/ext/redis" --strip 1 \
    && curl -fsSL https://pecl.php.net/get/xdebug | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 \
    && curl -fsSL https://pecl.php.net/get/msgpack | tar xvz -C "/usr/src/php/ext/msgpack" --strip 1 \
    && docker-php-ext-configure amqp \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp  \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install -j${NPROC} $phpModules \
    && docker-php-ext-enable apcu redis sockets xdebug

# Install libssl1.1.1
RUN wget http://ftp.pl.debian.org/debian/pool/main/o/openssl/libssl3_3.0.11-1~deb12u2_amd64.deb \
 && apt-get install -y ./libssl3_3.0.11-1~deb12u2_amd64.deb \
 && rm -r ./libssl3_3.0.11-1~deb12u2_amd64.deb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install Wkhtmltopdf
RUN apt-get update && apt-get install -y wkhtmltopdf
