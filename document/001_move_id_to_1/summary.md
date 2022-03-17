# 移動処理を管理するレコードの ID を 1 に変える

## 背景

現在、移動処理を管理しているレコードの ID が 1 となっていない。
1 になっていないことについては特に問題になっていないが、
定数値を決める際に 1 ではない値となっているとちょっと微妙である。
また BI ツールを導入することになり、そちらでは定数管理ができないので ID を直で使って管理することになる。
なので、このタイミングを逃すとこのまま微妙な ID のままになるため、今回で ID を 1 に合わせる。

## 方法

現在動いている DB から取得したダンプファイル(before.dump)を、
移動処理の ID を 1 にしたダンプファイル(after.dump)に変える。

事前に作業用の DB である midas_test というテーブルを作成しておく。

```
$ mysql -u root -p midas_test < before.dump

$ mysql -u root -p midas_test < check.sql > before.txt
$ mysql -u root -p midas_test < update.sql
$ mysql -u root -p midas_test < check.sql > after.txt

$ chsum before.txt
$ chsum after.txt

$ mysqldump -u root -p midas_test > after.dump
```
