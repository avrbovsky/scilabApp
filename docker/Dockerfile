FROM ubuntu:latest AS base

ENV DEBIAN_FRONTEND noninteractive

# Install dependencies
RUN apt update
RUN apt install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt update
RUN apt install -y php8.2\
    php8.2-cli\
    php8.2-common\
    php8.2-fpm\
    php8.2-mysql\
    php8.2-zip\
    php8.2-gd\
    php8.2-mbstring\
    php8.2-curl\
    php8.2-xml\
    php8.2-bcmath\
    php8.2-pdo

# # Install PHP fpm and cli for speed up
# RUN apt install -y php8.2-fpm php8.2-cli

RUN apt install -y curl && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js to run Vue application
RUN apt install -y ca-certificates gnupg
RUN mkdir -p /etc/apt/keyrings
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
ENV NODE_MAJOR 18
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
RUN apt update
RUN apt install -y nodejs

# Install scilab
RUN cd /tmp \
    && apt install -y wget libx11-6 libjogl2-java \
    && wget https://gitlab.com/scilab/scilab/-/archive/2024.0.0/scilab-2024.0.0.tar.gz \
    && tar -xzf scilab-2024.0.0.tar.gz \
    && mv scilab-2024.0.0/ /opt/scilab \
    && chown -R root:root /opt/scilab \
    && rm scilab-2024.0.0.tar.gz \
    && mkdir -p /scripts

# Copy run-script for executing scilab simulations
COPY docker/run-script.sh /scripts/
COPY docker/test-script.sh /scripts/

# Add permissions for running scripts
RUN chown -R root:root /root/ \
    && chmod +x /scripts/run-script.sh \
    && chmod +x /scripts/test-script.sh

# Setup Laravel
WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data /var/www/html

RUN npm install

RUN chmod +x ./docker/entrypoint-install.sh
ENV PORT=8000
ENTRYPOINT [ "docker/entrypoint-install.sh" ]
