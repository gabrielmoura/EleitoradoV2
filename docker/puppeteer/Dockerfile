# Use the official Chrome image as the base image
FROM alpine:latest

# Instalar dependências necessárias
RUN apk --no-cache add \
        udev \
        ttf-freefont \
        chromium \
    chromium-chromedriver \
        nss \
        freetype \
        freetype-dev \
        harfbuzz \
        ca-certificates \
        git \
        nodejs \
        npm \
    dbus \
    chromium-swiftshader \
    && npm install -g yarn

# Defina a variável de ambiente para o Chrome em modo headless
ENV CHROME_BIN=/usr/bin/chromium-browser
ENV CHROME_PATH=/usr/lib/chromium/

# Criar e definir um diretório de trabalho no contêiner
WORKDIR /app

# Expor a porta 9222 para a comunicação remota com o Chrome DevTools
EXPOSE 9222

# Comando para iniciar o Chrome em modo headless
CMD ["chromium-browser", "--headless", "--disable-gpu", "--remote-debugging-port=9222", "--no-sandbox","--disable-dev-shm-usage", "--disable-software-rasterizer", "--usegl=swiftshader"]
