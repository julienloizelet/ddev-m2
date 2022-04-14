ARG BASE_IMAGE
FROM $BASE_IMAGE

RUN disable_xdebug
RUN if [ ! -f /usr/bin/sed ]; then ln -sf /bin/sed /usr/bin/sed; fi
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confnew" --no-install-recommends --no-install-suggests build-essential make autoconf libc-dev pkg-config php-dev php-pear zlib1g-dev libmemcached-dev
RUN sudo chmod -R 664  $(pecl config-get php_dir)
# The "echo" below just forces accepting the "automatic" configuration, the same as hitting <RETURN>
RUN echo | sudo pecl install memcached-3.2.0

