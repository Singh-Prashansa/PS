/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package minesweeper;

/**
 *
 * @author Thinkpad
 */
import java.awt.*;
import java.util.*;
import javax.swing.*;
import java.awt.event.*;

public class Minesweeper {

    private class MineTile extends JButton {

        int r, c;

        MineTile(int r, int c) {
            this.c = c;
            this.r = r;
        }
    }
    int tileSize = 50;
    int rowNum = 10;
    int colNum = rowNum;
    int boardWidth = tileSize * colNum;
    int boardHeight = tileSize * rowNum;

    int mineCount=12;
    MineTile[][] board = new MineTile[rowNum][colNum];
    ArrayList<MineTile> mineList;
    Random random= new Random();

    int tilesClicked = 0;
    boolean gameOver = false;

    JFrame frame = new JFrame("Minesweeper");
    JPanel textPanel = new JPanel();
    JLabel textLabel = new JLabel();
    JPanel boardPanel = new JPanel();

    Minesweeper() {

        frame.setSize(boardWidth, boardHeight);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.setResizable(false);
        frame.setLocationRelativeTo(null);
        frame.setLayout(new BorderLayout());

        textLabel.setHorizontalAlignment(JLabel.CENTER);
        textLabel.setFont(new Font("Cambria", Font.BOLD, 25));
        textLabel.setText("Minesweeper: "+Integer.toString(mineCount));

        textPanel.setLayout(new BorderLayout());
        textPanel.add(textLabel);
        frame.add(textPanel, BorderLayout.NORTH);

        boardPanel.setLayout(new GridLayout(rowNum, colNum));
        frame.add(boardPanel);

        for (int r = 0; r < rowNum; r++) {
            for (int c = 0; c < colNum; c++) {
                MineTile tile = new MineTile(r, c);
                board[r][c] = tile;   //

                tile.setFocusable(false);
                tile.setMargin(new Insets(0, 0, 0, 0));
                tile.setFont(new Font("Arial Unicode MS", Font.PLAIN, 25));
//                tile.setText("💣");

                tile.addMouseListener(new MouseAdapter() {
//                    @Override
                    public void mousePressed(MouseEvent e) {
                        if (gameOver){
                            return;
                        }
                        MineTile tile = (MineTile) e.getSource();

//                        left-click
                        if (e.getButton() == MouseEvent.BUTTON1) {
                            if ("".equals(tile.getText())) {    //if tile doesn't contain flag or number (anything)
                                if (mineList.contains(tile)) {
                                    revealMines();
                                } else {
                                    checkMine(tile.r, tile.c);
                                }
                            }
                        } //                        right click
                        else if (e.getButton() == MouseEvent.BUTTON3) {
                            if ("".equals(tile.getText()) && tile.isEnabled()) {
                                tile.setText("🚩");
                            } else if ("🚩".equals(tile.getText())) {
                                tile.setText("");
                            }
                        }
                    }
                });
                boardPanel.add(tile);
            }
        }
        frame.setVisible(true); //visble only after the tiles are placed

        setMines();

    }

    void setMines() {
        mineList = new ArrayList<>();

//        mineList.add(board[0][0]);
//        mineList.add(board[2][2]);
//        mineList.add(board[4][9]);
//        mineList.add(board[7][4]);
//        mineList.add(board[8][2]);
    int mineLeft=mineCount;
    while(mineLeft>0){
        int r=random.nextInt(rowNum);
        int c=random.nextInt(colNum);
        MineTile tile= board[r][c];
//        check to see if the mine in that position is already there if yes then -- else nth
        if(!mineList.contains(tile)){
            mineList.add(tile);
            mineLeft--;
        }
    }

    }

    void revealMines() {
        for (int i = 0; i < mineList.size(); i++) {
            MineTile tile = mineList.get(i);
            tile.setText("💣");
        }
        gameOver=true;
        textLabel.setText("Game Over");
        
    }

    void checkMine(int r, int c) {
        if (r < 0 || r >= rowNum || c < 0 || c >= colNum) {
            return;
        }

        MineTile tile = board[r][c];
        if (!tile.isEnabled()) {
            return;
        }
        tile.setEnabled(false); //disable the button
        tilesClicked++;
        int minesFound = 0;

//        top 3
        minesFound += countMine(r - 1, c - 1);    //top left
        minesFound += countMine(r - 1, c);      //top
        minesFound += countMine(r - 1, c + 1);    //top right
//        right and left
        minesFound += countMine(r, c - 1);    // right
        minesFound += countMine(r, c + 1);    //left 
//        bottom 3
        minesFound += countMine(r + 1, c - 1);    //bottom right
        minesFound += countMine(r + 1, c);    //bottom right
        minesFound += countMine(r + 1, c + 1);    //bottom right

        if (minesFound > 0) {
            tile.setText(Integer.toString(minesFound));
        } else {
            tile.setText("");

//            top 3
            checkMine(r - 1, c - 1);
            checkMine(r - 1, c);
            checkMine(r - 1, c + 1);
//      left and right
            checkMine(r, c - 1);
            checkMine(r, c + 1);
//        bottom 3
            checkMine(r + 1, c - 1);
            checkMine(r + 1, c);
            checkMine(r + 1, c + 1);

        }
        if(tilesClicked== rowNum * colNum- mineList.size()){
            gameOver=true;
            textLabel.setText("Mines cleared");
        }

    }

    int countMine(int r, int c) {
        if (r < 0 || r >= rowNum || c < 0 || c >= colNum) {
            return 0;
        }
        if (mineList.contains(board[r][c])) {
            return 1;
        }
        return 0;
    }

    public static void main(String[] args) {
        new Minesweeper();
    }
}
