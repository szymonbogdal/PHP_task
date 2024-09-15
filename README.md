# Zadanie rekrutacyjne

Zadanie zrealizowałem tworząc API w php, które następnie dynamicznie wywołuję wykorzystując js.

## Główne założenia

 - **Raport wyświetlający nadpłaty na koncie klienta** - lista wszystkich faktur, których suma przelewów przekracza oczekiwaną kwotę.
 - **Raport wyświetlający niedopłaty za faktury** - lista faktur, które posiadają przelewy, jednak ich suma jest niewystarczająca.
 - **Raport wyświetlający nierozliczone faktury po terminie płatności** - lista faktur których termin płatności minął, a nie otrzymały żadnego przelewu.

## Realizacja zadania
  ### Backend (PHP) ###
 - **Router**: Wywołuje metody w kontrolerze, na podstawie akcji jaką otrzymał.
 - **Kontroler**: Tworzy obiekty poszczególnych modeli, i wywołuję na nich odpowiednie metody.
 - **Modele**: Realizują poszczególne zapytania do bazy danych, uwzględniająć parametry filtrowania oraz sortowania.
  ### Frontend (JavaScript) ###
  - **Dynamiczność**: Interfejs użytkownika komunikuję się z backendem w czasie rzeczywistym, aktualizując wyświetlane dane bez przeładowywania strony.
  - **Nawigacja**: Zakładki w pasku nawigacji zmieniają aktualną akcję, która następnie jest przekazywana do routera.
  - **Filtracja**: Wykorzystanie techniki "debounce" do optymalizacji zapytań podczas wpisywania kryteriów filtrowania.
  - **Sortowanie**: Kliknięcie na nagłówek kolumny w tabeli, sprawi że wyniki będą sortowane właśnie po tej kolumnie, ponowne naciśnięcie tej samej kolumny zmieni kierunek sortowania