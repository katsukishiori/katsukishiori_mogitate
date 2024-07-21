# mogitate   

  
## アプリケーションURL  
開発環境:http://localhost/  
phpMyAdmin:http://localhost:8080/  
  
## 機能一覧  
・商品検索機能  
・商品並び替え機能  
・商品登録機能  
・商品情報更新機能  
・商品情報削除機能
  
## 使用技術(実行環境)  
・PHP:   
・MySQL: 
・Laravel:8.83.27     

## ER図  
<img width="621" alt="スクリーンショット 2024-07-18 14 19 02" src="https://github.com/user-attachments/assets/435c6f5c-419c-427f-b2bb-c93745167d95">
  
## 環境構築  
### 1.リポジトリをクローンします。    
     git clone https://github.com/katsukishiori/katsukishiori_mogitate.git        
  
### 2.Dockerコンテナを起動します。  
     docker-compose up -d --build      
  
### 3.PHP コンテナへログインし、Laravel アプリケーションの準備をします。  
  #### ❶PHPコンテナへのログイン
    docker-compose exec php bash    
  
  #### ❷Laravelアプリケーションの依存関係をインストール  
     composer update    

  #### ❸環境変数の設定
  env.exampleファイルをコピーして.envファイルを作成します。
    
    cp .env.example .env       

  以下のように必要な環境変数を設定します。  
    
      DB_CONNECTION=mysql  
      DB_HOST=mysql  
      DB_PORT=3306  
      DB_DATABASE=laravel_db  
      DB_USERNAME=laravel_user  
      DB_PASSWORD=laravel_pass  
      
    
  #### ❹アプリケーションキーの生成  
     php artisan key:generate        

  #### ❺データベーステーブルの作成   
     php artisan migrate      

  #### ❻初期データの投入  
     php artisan db:seed  

### 4.シンボリックリンクの作成
storageフォルダに保存した画像をpublicフォルダを通じてアクセスするために、publicフォルダにstorageフォルダのショートカットを作ります。
    
    php artisan storage:link  
   

### 5.以下の URL にアクセスし、トップページを表示します。  
http://localhost/  
    

